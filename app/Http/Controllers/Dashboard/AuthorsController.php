<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Http\Requests\Author\StoreRequest;
use App\Http\Requests\Author\UpdateRequest;

class AuthorsController extends Controller
{
    public function index()
    {
        $authors = Author::withCount('books')->latest()->paginate(10);
        return view('authors.index', compact('authors'));
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(StoreRequest $request)
    {
        Author::create($request->validated());
        return redirect()->route('dashboard.authors.index')->with('success', __('dashboard.author_created'));
    }

    public function show(Author $author)
    {
        $author->load('books.category');
        return view('authors.show', compact('author'));
    }

    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    public function update(UpdateRequest $request, Author $author)
    {
        $author->update($request->validated());
        return redirect()->route('dashboard.authors.index')->with('success', __('dashboard.author_updated'));
    }

    public function destroy(Author $author)
    {
        if ($author->books()->count() > 0) {
            return redirect()->route('authors.index')->with('error', __('لا يمكن حذف هذا المؤلف لأنه مرتبط بكتب.'));
        }
        
        $author->delete();
        return redirect()->route('dashboard.authors.index')->with('success', __('dashboard.author_deleted'));
    }
} 