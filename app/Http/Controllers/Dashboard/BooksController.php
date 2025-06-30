<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Http\Requests\Book\StoreRequest;
use App\Http\Requests\Book\UpdateRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\Dashboard\BookService;
use App\Http\Traits\HandlesImageUploads;

class BooksController extends Controller
{
    use HandlesImageUploads;

    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index()
    {
        $books = $this->bookService->listBooks();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->uploadImage($request->file('cover_image'), 'covers');
        }
        $this->bookService->createBook($data);
        return redirect()->route('dashboard.books.index')->with('success', __('dashboard.book_created'));
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(UpdateRequest $request, Book $book)
    {
        $data = $request->validated();
        if ($request->hasFile('cover_image')) {
            $this->deleteImage($book->cover_image);
            $data['cover_image'] = $this->uploadImage($request->file('cover_image'), 'covers');
        }
        $this->bookService->updateBook($book, $data);
        return redirect()->route('dashboard.books.index')->with('success', __('dashboard.book_updated'));
    }

    public function destroy(Book $book)
    {
        $this->deleteImage($book->cover_image);
        $this->bookService->deleteBook($book);
        return redirect()->route('dashboard.books.index')->with('success', __('dashboard.book_deleted'));
    }
} 