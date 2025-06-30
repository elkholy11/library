<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Services\BookService;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index(Request $request)
    {
        $books = $this->bookService->listBooks();
        return BookResource::collection($books);
    }

    public function show(Book $book)
    {
        $book = $this->bookService->showBook($book);
        return new BookResource($book);
    }

    public function search(Request $request)
    {
        $books = $this->bookService->searchBooks($request->q ?? null);
        return BookResource::collection($books);
    }
} 