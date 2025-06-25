<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::with(['author', 'category'])->paginate(15);
        return BookResource::collection($books);
    }

    public function show(Book $book)
    {
        $book->load(['author', 'category']);
        return new BookResource($book);
    }

    public function search(Request $request)
    {
        $query = Book::query();
        if ($request->has('q')) {
            $q = $request->q;
            $query->where('title', 'like', "%$q%")
                  ->orWhere('title_en', 'like', "%$q%")
                  ->orWhere('isbn', 'like', "%$q%")
                  ->orWhereHas('author', function($a) use ($q) {
                      $a->where('name', 'like', "%$q%")
                        ->orWhere('name_en', 'like', "%$q%")
                        ;
                  });
        }
        $books = $query->with(['author', 'category'])->paginate(15);
        return BookResource::collection($books);
    }
} 