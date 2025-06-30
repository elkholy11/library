<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Services\Dashboard\CategoryService;

class CategoriesController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->listCategories();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreRequest $request)
    {
        $this->categoryService->createCategory($request->validated());
        return redirect()->route('dashboard.categories.index')->with('success', __('dashboard.category_created'));
    }

    public function show(Category $category)
    {
        $category = $this->categoryService->showCategory($category);
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(UpdateRequest $request, Category $category)
    {
        $this->categoryService->updateCategory($category, $request->validated());
        return redirect()->route('dashboard.categories.index')->with('success', __('dashboard.category_updated'));
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        $this->categoryService->deleteCategory($category);
        return redirect()->route('dashboard.categories.index')->with('success', __('dashboard.category_deleted'));
    }
}
