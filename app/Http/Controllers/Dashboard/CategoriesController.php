<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('books')->latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreRequest $request)
    {
        Category::create($request->validated());
        return redirect()->route('dashboard.categories.index')->with('success', __('dashboard.category_created'));
    }

    public function show(Category $category)
    {
        $category->load('books.author');
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(UpdateRequest $request, Category $category)
    {
        $category->update($request->validated());
        return redirect()->route('dashboard.categories.index')->with('success', __('dashboard.category_updated'));
    }

    public function destroy(Category $category)
    {
        if ($category->books()->count() > 0) {
            return redirect()->route('dashboard.categories.index')->with('error', __('لا يمكن حذف هذا التصنيف لأنه مرتبط بكتب.'));
        }
        $category->delete();
        return redirect()->route('dashboard.categories.index')->with('success', __('dashboard.category_deleted'));
    }
}
