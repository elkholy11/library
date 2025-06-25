<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Resources\AuthorResource;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $authors = Author::paginate(15);
        return AuthorResource::collection($authors);
    }

    public function show(Author $author)
    {
        $author->load('books');
        return new AuthorResource($author);
    }
} 