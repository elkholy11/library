<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BorrowResource;
use App\Http\Requests\Borrow\StoreRequest;
use Illuminate\Validation\ValidationException;

class BorrowController extends Controller
{
    public function index(Request $request)
    {
        $borrows = $request->user()->borrows()->with('book')->latest()->paginate(15);
        return BorrowResource::collection($borrows);
    }

    public function show(Borrow $borrow)
    {
        $this->authorize('view', $borrow);
        $borrow->load('book', 'user');
        return new BorrowResource($borrow);
    }

    public function store(StoreRequest $request)
    {
        $book = Book::findOrFail($request->validated('book_id'));

        if ($book->available_quantity < 1) {
            throw ValidationException::withMessages([
               'book_id' => __('هذا الكتاب غير متاح للاستعارة حاليًا.')
            ]);
        }
        
        // Check if user already borrowed this book and not returned it
        $existingBorrow = $request->user()->borrows()
                                    ->where('book_id', $book->id)
                                    ->where('status', 'borrowed')
                                    ->exists();

        if ($existingBorrow) {
            throw ValidationException::withMessages([
               'book_id' => __('لقد قمت باستعارة هذا الكتاب بالفعل ولم تقم بإرجاعه بعد.')
            ]);
        }

        $borrow = $request->user()->borrows()->create([
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'status' => 'borrowed',
        ]);

        $book->decrement('available_quantity');

        return new BorrowResource($borrow->load('book'));
    }

    public function update(Request $request, Borrow $borrow)
    {
        $this->authorize('update', $borrow);
        $validated = $request->validate([
            'status' => 'required|in:borrowed,returned',
            'returned_at' => 'nullable|date'
        ]);
        $borrow->update($validated);
        return response()->json([
            'message' => 'Borrow updated successfully',
            'borrow' => new BorrowResource($borrow->fresh('book'))
        ]);
    }

    public function destroy(Request $request, Borrow $borrow)
    {
        $this->authorize('delete', $borrow);
        
        // API users should probably not be able to delete a borrow record.
        // Maybe only 'cancel' if it's a request? But this is a direct borrow.
        // For now, let's disable it.
        return response()->json(['message' => 'Not supported'], 405);
    }
} 