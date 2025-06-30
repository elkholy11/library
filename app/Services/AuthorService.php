<?php

namespace App\Services;

use App\Models\Author;

class AuthorService
{
    public function listAuthors()
    {
        return Author::paginate(15);
    }

    public function showAuthor(Author $author)
    {
        $author->load('books');
        return $author;
    }
} 