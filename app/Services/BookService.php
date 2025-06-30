<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function listBooks()
    {
        return Book::with(['author', 'category'])->paginate(15);
    }

    public function showBook(Book $book)
    {
        $book->load(['author', 'category']);
        return $book;
    }

    public function searchBooks(?string $q)
    {
        $query = Book::query();
        if ($q) {
            $query->where('title', 'like', "%$q%")
                  ->orWhere('title_en', 'like', "%$q%")
                  ->orWhere('isbn', 'like', "%$q%")
                  ->orWhereHas('author', function($a) use ($q) {
                      $a->where('name', 'like', "%$q%")
                        ->orWhere('name_en', 'like', "%$q%")
                        ;
                  });
        }
        return $query->with(['author', 'category'])->paginate(15);
    }
} 