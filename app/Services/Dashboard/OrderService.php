<?php

namespace App\Services\Dashboard;

use App\Models\Order;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function listOrders()
    {
        return Order::with('user', 'books')->latest()->paginate(10);
    }

    public function createOrder(array $data)
    {
        return DB::transaction(function () use ($data) {
            $order = Order::create([
                'user_id' => $data['user_id'],
                'status' => Order::STATUS_PENDING,
            ]);
            $booksToAttach = [];
            foreach ($data['books'] as $bookData) {
                $booksToAttach[$bookData['book_id']] = ['quantity' => $bookData['quantity']];
                Book::find($bookData['book_id'])->decrement('available_quantity', $bookData['quantity']);
            }
            $order->books()->attach($booksToAttach);
            return $order;
        });
    }

    public function updateOrder(Order $order, array $data)
    {
        $oldStatus = $order->status;
        if ($oldStatus === Order::STATUS_PENDING && $data['status'] === Order::STATUS_REJECTED) {
            DB::transaction(function () use ($order, $data) {
                foreach ($order->books as $book) {
                    Book::find($book->id)->increment('available_quantity', $book->pivot->quantity);
                }
                $order->update($data);
            });
        } else {
            $order->update($data);
        }
        return $order;
    }

    public function deleteOrder(Order $order)
    {
        if ($order->status === Order::STATUS_PENDING) {
            DB::transaction(function () use ($order) {
                foreach ($order->books as $book) {
                    Book::find($book->id)->increment('available_quantity', $book->pivot->quantity);
                }
                $order->delete();
            });
        } else {
            $order->delete();
        }
    }
} 