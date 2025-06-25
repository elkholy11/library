<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BookRequest;
use Illuminate\Http\Request;
use App\Http\Resources\BookRequest\BookRequestResource;
use App\Http\Requests\BookRequest\StoreBookRequestRequest;

class BookRequestController extends Controller
{
    public function index(Request $request)
    {
        $bookRequests = BookRequest::where('user_id', $request->user()->id)->paginate(15);
        return BookRequestResource::collection($bookRequests);
    }

    public function show(BookRequest $bookRequest)
    {
        $this->authorize('view', $bookRequest);
        return new BookRequestResource($bookRequest);
    }

    public function store(StoreBookRequestRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $bookRequest = BookRequest::create($data);
        return new BookRequestResource($bookRequest);
    }

    public function update(Request $request, BookRequest $bookRequest)
    {
        $this->authorize('update', $bookRequest);
        $bookRequest->update($request->all());
        return new BookRequestResource($bookRequest);
    }

    public function destroy(Request $request, BookRequest $bookRequest)
    {
        $this->authorize('delete', $bookRequest);
        $bookRequest->delete();
        return response()->json(['message' => __('تم حذف طلب الكتاب بنجاح')]);
    }
} 