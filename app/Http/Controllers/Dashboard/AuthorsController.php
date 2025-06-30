<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Http\Requests\Author\StoreRequest;
use App\Http\Requests\Author\UpdateRequest;
use App\Services\Dashboard\AuthorService;

class AuthorsController extends Controller
{
    protected $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index()
    {
        $authors = $this->authorService->listAuthors();
        return view('authors.index', compact('authors'));
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorService->createAuthor($request->validated());
        return redirect()->route('dashboard.authors.index')->with('success', __('dashboard.author_created'));
    }

    public function show(Author $author)
    {
        $author = $this->authorService->showAuthor($author);
        return view('authors.show', compact('author'));
    }

    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    public function update(UpdateRequest $request, Author $author)
    {
        $this->authorService->updateAuthor($author, $request->validated());
        return redirect()->route('dashboard.authors.index')->with('success', __('dashboard.author_updated'));
    }

    public function destroy(Author $author)
    {
        $this->authorize('delete', $author);
        $this->authorService->deleteAuthor($author);
        return redirect()->route('dashboard.authors.index')->with('success', __('dashboard.author_deleted'));
    }
} 