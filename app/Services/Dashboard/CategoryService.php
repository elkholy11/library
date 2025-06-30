<?php

namespace App\Services\Dashboard;

use App\Models\Category;

class CategoryService
{
    public function listCategories()
    {
        return Category::withCount('books')->latest()->paginate(10);
    }

    public function createCategory(array $data)
    {
        return Category::create($data);
    }

    public function updateCategory(Category $category, array $data)
    {
        $category->update($data);
        return $category;
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        return true;
    }

    public function showCategory(Category $category)
    {
        $category->load('books.author');
        return $category;
    }
} 