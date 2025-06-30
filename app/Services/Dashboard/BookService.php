<?php

namespace App\Services\Dashboard;

use App\Models\Book;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BookService
{
    public function listBooks()
    {
        return Book::with('author', 'category')->latest()->paginate(10);
    }

    public function createBook(array $data)
    {
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }
        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Book::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter++;
        }
        // Set default values
        $data['available_quantity'] = $data['quantity'];
        $data['status'] = 'available';
        $data['is_active'] = true;
        return Book::create($data);
    }

    public function updateBook(Book $book, array $data)
    {
        // Generate slug if not provided or title changed
        if (empty($data['slug']) || $data['title'] !== $book->title) {
            $data['slug'] = Str::slug($data['title']);
            // Ensure slug is unique
            $originalSlug = $data['slug'];
            $counter = 1;
            while (Book::where('slug', $data['slug'])->where('id', '!=', $book->id)->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter++;
            }
        }
        $book->update($data);
        return $book;
    }

    public function deleteBook(Book $book)
    {
        $book->delete();
    }
} 