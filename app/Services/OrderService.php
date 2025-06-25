<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderService
{
    /**
     * Create a new order from the dashboard.
     *
     * @param array $validatedData
     * @return \App\Models\Order
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createOrderFromDashboard(array $validatedData): Order
    {
        return DB::transaction(function () use ($validatedData) {
            $order = Order::create([
                'user_id' => $validatedData['user_id'],
                'status' => 'pending'
            ]);

            $booksToAttach = [];

            foreach ($validatedData['books'] as $key => $bookData) {
                $book = Book::findOrFail($bookData['book_id']);
                $quantity = $bookData['quantity'];

                if ($book->available_quantity < $quantity) {
                    throw ValidationException::withMessages([
                        "books.{$key}.quantity" => "الكمية المطلوبة للكتاب '{$book->title}' غير متوفرة. المتوفر: {$book->available_quantity}"
                    ]);
                }

                $booksToAttach[$book->id] = ['quantity' => $quantity];
                $book->decrement('available_quantity', $quantity);
            }

            $order->books()->attach($booksToAttach);

            return $order;
        });
    }
} 