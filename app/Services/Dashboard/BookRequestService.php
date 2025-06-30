<?php

namespace App\Services\Dashboard;

use App\Models\BookRequest;

class BookRequestService
{
    public function listBookRequests()
    {
        return BookRequest::with('user')->latest()->paginate(10);
    }

    public function createBookRequest(array $data)
    {
        return BookRequest::create($data);
    }

    public function updateBookRequest(BookRequest $bookRequest, array $data)
    {
        $bookRequest->update($data);
        return $bookRequest;
    }

    public function deleteBookRequest(BookRequest $bookRequest)
    {
        $bookRequest->delete();
    }
} 