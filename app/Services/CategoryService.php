<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function listCategories()
    {
        return Category::withCount('books')->paginate(15);
    }

    public function showCategory(Category $category)
    {
        $category->load('books.author');
        $category->loadCount('books');
        return $category;
    }
} 