<?php

namespace App\Services\Dashboard;

use App\Models\Author;

class AuthorService
{
    public function listAuthors()
    {
        return Author::withCount('books')->latest()->paginate(10);
    }

    public function createAuthor(array $data)
    {
        return Author::create($data);
    }

    public function updateAuthor(Author $author, array $data)
    {
        $author->update($data);
        return $author;
    }

    public function deleteAuthor(Author $author)
    {
        $author->delete();
        return true;
    }

    public function showAuthor(Author $author)
    {
        $author->load('books.category');
        return $author;
    }
} 