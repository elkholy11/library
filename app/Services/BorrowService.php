<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BorrowService
{
    /**
     * Create a new borrow record from the dashboard.
     *
     * @param array $validatedData
     * @return \App\Models\Borrow
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createBorrowFromDashboard(array $validatedData): Borrow
    {
        $book = Book::findOrFail($validatedData['book_id']);
        $user = User::findOrFail($validatedData['user_id']);

        // 1. Check book availability
        if ($book->available_quantity < 1) {
            throw ValidationException::withMessages([
               'book_id' => __('هذا الكتاب غير متاح للاستعارة حاليًا.')
            ]);
        }

        // 2. Check if user already borrowed this book and not returned it
        $existingBorrow = $user->borrows()
                                ->where('book_id', $book->id)
                                ->where('status', 'borrowed')
                                ->exists();

        if ($existingBorrow) {
            throw ValidationException::withMessages([
               'book_id' => __('هذا المستخدم قد استعار هذا الكتاب بالفعل ولم يرجعه بعد.')
            ]);
        }

        // 3. Create borrow record and decrement book quantity
        return DB::transaction(function () use ($validatedData, $book) {
            $borrow = Borrow::create([
                'user_id' => $validatedData['user_id'],
                'book_id' => $validatedData['book_id'],
                'borrowed_at' => now(),
                'status' => 'borrowed',
            ]);

            $book->decrement('available_quantity');

            return $borrow;
        });
    }
} 