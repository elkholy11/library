<?php

namespace App\Services;

use App\Models\BookRequest;
use App\Models\User;

class BookRequestService
{
    public function listUserBookRequests(User $user)
    {
        return BookRequest::where('user_id', $user->id)->paginate(15);
    }

    public function showBookRequest(BookRequest $bookRequest)
    {
        return $bookRequest;
    }

    public function storeBookRequest(User $user, array $data)
    {
        $data['user_id'] = $user->id;
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