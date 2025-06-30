<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;

class BorrowService
{
    public function listUserBorrows(User $user)
    {
        return $user->borrows()->with('book')->latest()->paginate(15);
    }

    public function showBorrow(Borrow $borrow)
    {
        $borrow->load('book', 'user');
        return $borrow;
    }

    public function storeBorrow(User $user, array $data)
    {
        $book = Book::findOrFail($data['book_id']);

        $this->validateBookForBorrowing($book, $user);

        return DB::transaction(function () use ($user, $book) {
            $borrow = $user->borrows()->create([
                'book_id' => $book->id,
                'borrowed_at' => now(),
                'status' => 'borrowed',
            ]);

            $book->decrement('available_quantity');

            return $borrow->load('book');
        });
    }

    public function updateBorrow(Borrow $borrow, array $data)
    {
        $borrow->update($data);
        return $borrow->fresh('book');
    }

    /**
     * @throws ValidationException
     */
    private function validateBookForBorrowing(Book $book, User $user): void
    {
        if ($book->available_quantity < 1) {
            throw ValidationException::withMessages([
                'book_id' => __('هذا الكتاب غير متاح للاستعارة حاليًا.')
            ]);
        }

        if ($this->userHasActiveBorrowForBook($user, $book)) {
            throw ValidationException::withMessages([
                'book_id' => __('لقد قمت باستعارة هذا الكتاب بالفعل ولم تقم بإرجاعه بعد.')
            ]);
        }
    }

    private function userHasActiveBorrowForBook(User $user, Book $book): bool
    {
        return $user->borrows()
            ->where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->exists();
    }
} 