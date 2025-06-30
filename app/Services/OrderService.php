<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderService
{
    public function listUserOrders(User $user)
    {
        return Order::where('user_id', $user->id)
                    ->with('books')
                    ->latest()
                    ->paginate(15);
    }

    public function showOrder(Order $order)
    {
        $order->load('user', 'books');
        return $order;
    }

    public function storeOrder(User $user, array $validated)
    {
        $booksToOrder = $this->validateAndPrepareBooks($validated['books']);

        return DB::transaction(function () use ($user, $booksToOrder) {
            $order = $user->orders()->create(['status' => 'pending']);
            $this->attachBooksToOrder($order, $booksToOrder);
            return $order->load('books');
        });
    }

    public function updateOrderStatus(Order $order, string $status)
    {
        $order->update(['status' => $status]);
        return $order->fresh('books');
    }

    public function deleteOrder(Order $order)
    {
        DB::transaction(function () use ($order) {
            foreach ($order->books as $book) {
                Book::find($book->id)->increment('available_quantity', $book->pivot->quantity);
            }
            $order->delete();
        });
    }

    /**
     * @throws ValidationException
     */
    private function validateAndPrepareBooks(array $booksData): array
    {
        $booksToOrder = [];
        foreach ($booksData as $bookData) {
            $book = Book::findOrFail($bookData['book_id']);
            $quantity = $bookData['quantity'];

            if ($book->available_quantity < $quantity) {
                throw ValidationException::withMessages([
                    'books' => "الكتاب '{$book->title}' غير متوفر بالكمية المطلوبة. المتوفر: {$book->available_quantity}"
                ]);
            }
            $booksToOrder[] = ['book' => $book, 'quantity' => $quantity];
        }
        return $booksToOrder;
    }

    private function attachBooksToOrder(Order $order, array $booksToOrder): void
    {
        $booksToAttach = [];
        foreach ($booksToOrder as $data) {
            $data['book']->decrement('available_quantity', $data['quantity']);
            $booksToAttach[$data['book']->id] = ['quantity' => $data['quantity']];
        }
        $order->books()->attach($booksToAttach);
    }
} 