<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Resources\AuthorResource;
use App\Services\AuthorService;

class AuthorController extends Controller
{
    protected $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index(Request $request)
    {
        $authors = $this->authorService->listAuthors();
        return AuthorResource::collection($authors);
    }

    public function show(Author $author)
    {
        $author = $this->authorService->showAuthor($author);
        return new AuthorResource($author);
    }
} 