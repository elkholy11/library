<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookRequest;
use App\Models\Borrow;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stats = [
            'books' => Book::count(),
            'users' => User::count(),
            'borrows' => Borrow::where('status', 'borrowed')->count(),
            'authors' => Author::count(),
            'categories' => Category::count(),
            'book_requests' => BookRequest::where('status', 'pending')->count(),
            'orders' => Order::where('status', 'approved')->count(),
        ];

        return view('dashboard.index', compact('stats'));
    }
} 