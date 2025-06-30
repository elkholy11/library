<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BookRequest;
use Illuminate\Http\Request;
use App\Http\Resources\BookRequest\BookRequestResource;
use App\Http\Requests\BookRequest\StoreBookRequestRequest;
use App\Services\BookRequestService;

class BookRequestController extends Controller
{
    protected $bookRequestService;

    public function __construct(BookRequestService $bookRequestService)
    {
        $this->bookRequestService = $bookRequestService;
    }

    public function index(Request $request)
    {
        $bookRequests = $this->bookRequestService->listUserBookRequests($request->user());
        return BookRequestResource::collection($bookRequests);
    }

    public function show(BookRequest $bookRequest)
    {
        $this->authorize('view', $bookRequest);
        $bookRequest = $this->bookRequestService->showBookRequest($bookRequest);
        return new BookRequestResource($bookRequest);
    }

    public function store(StoreBookRequestRequest $request)
    {
        $bookRequest = $this->bookRequestService->storeBookRequest($request->user(), $request->validated());
        return new BookRequestResource($bookRequest);
    }

    public function update(Request $request, BookRequest $bookRequest)
    {
        $this->authorize('update', $bookRequest);
        $bookRequest = $this->bookRequestService->updateBookRequest($bookRequest, $request->all());
        return new BookRequestResource($bookRequest);
    }

    public function destroy(Request $request, BookRequest $bookRequest)
    {
        $this->authorize('delete', $bookRequest);
        $this->bookRequestService->deleteBookRequest($bookRequest);
        return response()->json(['message' => __('تم حذف طلب الكتاب بنجاح')]);
    }
} 