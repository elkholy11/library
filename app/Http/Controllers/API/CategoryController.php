<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('books')->paginate(15);
        return CategoryResource::collection($categories);
    }

    public function show(Category $category)
    {
        $category->load('books.author');
        $category->loadCount('books');
        return new CategoryResource($category);
    }
} 