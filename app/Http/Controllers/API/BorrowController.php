<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BorrowResource;
use App\Http\Requests\Borrow\StoreRequest;
use App\Http\Requests\API\Borrow\UpdateRequest;
use Illuminate\Validation\ValidationException;
use App\Services\BorrowService;

class BorrowController extends Controller
{
    protected $borrowService;

    public function __construct(BorrowService $borrowService)
    {
        $this->borrowService = $borrowService;
    }

    public function index(Request $request)
    {
        $borrows = $this->borrowService->listUserBorrows($request->user());
        return BorrowResource::collection($borrows);
    }

    public function show(Borrow $borrow)
    {
        $this->authorize('view', $borrow);
        $borrow = $this->borrowService->showBorrow($borrow);
        return new BorrowResource($borrow);
    }

    public function store(StoreRequest $request)
    {
        $borrow = $this->borrowService->storeBorrow($request->user(), $request->validated());
        return new BorrowResource($borrow);
    }

    public function update(UpdateRequest $request, Borrow $borrow)
    {
        $this->authorize('update', $borrow);
        $borrow = $this->borrowService->updateBorrow($borrow, $request->validated());
        return response()->json([
            'message' => 'Borrow updated successfully',
            'borrow' => new BorrowResource($borrow)
        ]);
    }

    public function destroy(Request $request, Borrow $borrow)
    {
        $this->authorize('delete', $borrow);
        
        // API users should probably not be able to delete a borrow record.
        // Maybe only 'cancel' if it's a request? But this is a direct borrow.
        // For now, let's disable it.
        return response()->json(['message' => 'Not supported'], 405);
    }
} 