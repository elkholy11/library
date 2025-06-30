<?php

namespace App\Services\Dashboard;

use App\Models\Borrow;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class BorrowService
{
    public function listBorrows()
    {
        return Borrow::with('user', 'book')->latest()->paginate(10);
    }

    public function createBorrowFromDashboard(array $data)
    {
        return DB::transaction(function () use ($data) {
            $borrow = Borrow::create([
                'user_id' => $data['user_id'],
                'book_id' => $data['book_id'],
                'borrowed_at' => $data['borrowed_at'],
                'due_date' => $data['due_date'],
                'status' => Borrow::STATUS_BORROWED,
            ]);
            $book = Book::findOrFail($data['book_id']);
            $book->decrement('available_quantity');
            return $borrow;
        });
    }

    public function updateBorrow(Borrow $borrow, array $data)
    {
        $isReturning = $data['status'] === Borrow::STATUS_RETURNED && $borrow->status === Borrow::STATUS_BORROWED;
        $borrow->update($data);
        if ($isReturning) {
            $borrow->book->increment('available_quantity');
            if (empty($data['returned_at'])) {
                $borrow->update(['returned_at' => now()]);
            }
        }
        return $borrow;
    }

    public function deleteBorrow(Borrow $borrow)
    {
        if ($borrow->status === Borrow::STATUS_BORROWED) {
            $borrow->book->increment('available_quantity');
        }
        $borrow->delete();
    }
} 