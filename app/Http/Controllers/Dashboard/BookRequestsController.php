<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\BookRequest;
use App\Http\Requests\BookRequest\StoreBookRequestRequest;
use App\Http\Requests\BookRequest\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Dashboard\BookRequestService;

class BookRequestsController extends Controller
{
    protected $bookRequestService;

    public function __construct(BookRequestService $bookRequestService)
    {
        $this->bookRequestService = $bookRequestService;
    }

    public function index()
    {
        $bookRequests = $this->bookRequestService->listBookRequests();
        return view('book_requests.index', compact('bookRequests'));
    }

    public function create()
    {
        return view('book_requests.create');
    }

    public function store(StoreBookRequestRequest $request)
    {
        $this->bookRequestService->createBookRequest($request->validated());
        return redirect()->route('dashboard.book_requests.index')->with('success', __('dashboard.book_request_created_successfully'));
    }

    public function show(BookRequest $bookRequest)
    {
        return view('book_requests.show', compact('bookRequest'));
    }

    public function edit(BookRequest $bookRequest)
    {
        return view('book_requests.edit', compact('bookRequest'));
    }

    public function update(UpdateRequest $request, BookRequest $bookRequest)
    {
        $this->bookRequestService->updateBookRequest($bookRequest, $request->validated());
        return redirect()->route('dashboard.book_requests.index')->with('success', __('dashboard.book_request_updated_successfully'));
    }

    public function destroy(BookRequest $bookRequest)
    {
        $this->bookRequestService->deleteBookRequest($bookRequest);
        return redirect()->route('dashboard.book_requests.index')->with('success', __('dashboard.book_request_deleted_successfully'));
    }
} 