<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Http\Requests\Order\StoreRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
                        ->with('books')
                        ->latest()
                        ->paginate(15);
        return OrderResource::collection($orders);
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('user', 'books');
        return new OrderResource($order);
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        $order = DB::transaction(function () use ($validated, $request) {
            $order = $request->user()->orders()->create(['status' => 'pending']);
            $booksToAttach = [];

            foreach ($validated['books'] as $bookData) {
                $book = Book::findOrFail($bookData['book_id']);
                $quantity = $bookData['quantity'];

                if ($book->available_quantity < $quantity) {
                     throw ValidationException::withMessages([
                        'books' => "الكتاب '{$book->title}' غير متوفر بالكمية المطلوبة. المتوفر: {$book->available_quantity}"
                    ]);
                }
                
                $booksToAttach[$book->id] = ['quantity' => $quantity];
                $book->decrement('available_quantity', $quantity);
            }

            $order->books()->attach($booksToAttach);
            return $order;
        });

        return new OrderResource($order->load('books'));
    }

    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order);
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,delivered',
        ]);
        $order->update(['status' => $validated['status']]);
        return response()->json([
            'message' => 'Order updated successfully',
            'order' => new OrderResource($order->fresh('books'))
        ]);
    }

    public function destroy(Request $request, Order $order)
    {
        $this->authorize('delete', $order);

        DB::transaction(function () use ($order) {
            // Return the books to stock
            foreach ($order->books as $book) {
                Book::find($book->id)->increment('available_quantity', $book->pivot->quantity);
            }
            $order->delete();
        });

        return response()->json(['message' => __('تم حذف الطلب بنجاح')]);
    }
} 