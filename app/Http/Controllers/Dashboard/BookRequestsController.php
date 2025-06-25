<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\BookRequest;
use App\Http\Requests\BookRequest\StoreBookRequestRequest;
use App\Http\Requests\BookRequest\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class BookRequestsController extends Controller
{
    public function index()
    {
        $bookRequests = BookRequest::with('user')->latest()->paginate(10);
        return view('book_requests.index', compact('bookRequests'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->get();
        return view('book_requests.create', compact('users'));
    }

    public function store(StoreBookRequestRequest $request)
    {
        BookRequest::create($request->validated());

        return redirect()->route('dashboard.book_requests.index')->with('success', __('dashboard.book_request_created_successfully'));
    }

    public function show(BookRequest $bookRequest)
    {
        return view('book_requests.show', compact('bookRequest'));
    }

    public function edit(BookRequest $bookRequest)
    {
        $users = User::where('role', 'user')->get();
        return view('book_requests.edit', compact('bookRequest', 'users'));
    }

    public function update(UpdateRequest $request, BookRequest $bookRequest)
    {
        $bookRequest->update($request->validated());

        return redirect()->route('dashboard.book_requests.index')->with('success', __('dashboard.book_request_updated_successfully'));
    }

    public function destroy(BookRequest $bookRequest)
    {
        $bookRequest->delete();
        return redirect()->route('dashboard.book_requests.index')->with('success', __('dashboard.book_request_deleted_successfully'));
    }
} 