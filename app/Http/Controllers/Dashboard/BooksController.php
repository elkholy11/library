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

class BooksController extends Controller
{
    public function index()
    {
        $books = Book::with('author', 'category')->latest()->paginate(10);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('books.create', compact('authors', 'categories'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

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

        Book::create($data);
        return redirect()->route('dashboard.books.index')->with('success', __('dashboard.book_created'));
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('books.edit', compact('book', 'authors', 'categories'));
    }

    public function update(UpdateRequest $request, Book $book)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            // Delete old image if it exists
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

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
        return redirect()->route('dashboard.books.index')->with('success', __('dashboard.book_updated'));
    }

    public function destroy(Book $book)
    {
        // Delete image file if it exists
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        $book->delete();
        return redirect()->route('dashboard.books.index')->with('success', __('dashboard.book_deleted'));
    }
} 