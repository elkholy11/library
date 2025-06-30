<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Http\Requests\Order\StoreRequest;
use App\Http\Requests\API\Order\UpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $orders = $this->orderService->listUserOrders($request->user());
        return OrderResource::collection($orders);
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order = $this->orderService->showOrder($order);
        return new OrderResource($order);
    }

    public function store(StoreRequest $request)
    {
        $order = $this->orderService->storeOrder($request->user(), $request->validated());
        return new OrderResource($order);
    }

    public function update(UpdateRequest $request, Order $order)
    {
        $this->authorize('update', $order);
        $order = $this->orderService->updateOrderStatus($order, $request->validated()['status']);
        return response()->json([
            'message' => 'Order updated successfully',
            'order' => new OrderResource($order)
        ]);
    }

    public function destroy(Request $request, Order $order)
    {
        $this->authorize('delete', $order);
        $this->orderService->deleteOrder($order);
        return response()->json(['message' => __('تم حذف الطلب بنجاح')]);
    }
} 