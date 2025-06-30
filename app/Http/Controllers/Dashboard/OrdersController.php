<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Requests\Order\UpdateRequest;
use App\Http\Requests\Order\DashboardStoreRequest;
use App\Models\Book;
use App\Models\User;
use App\Services\Dashboard\OrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrdersController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->listOrders();
        return view('orders.index', compact('orders'));
    }

    // Creating orders from dashboard is disabled
    public function create()
    {
        return view('orders.create');
    }

    public function store(DashboardStoreRequest $request)
    {
        $this->orderService->createOrder($request->validated());
        return redirect()->route('dashboard.orders.index')->with('success', __('dashboard.order_created'));
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load('user', 'books');
        return view('orders.edit', compact('order'));
    }

    public function update(UpdateRequest $request, Order $order)
    {
        $this->orderService->updateOrder($order, $request->validated());
        return redirect()->route('dashboard.orders.index')->with('success', __('dashboard.order_updated'));
    }

    public function destroy(Order $order)
    {
        $this->orderService->deleteOrder($order);
        return redirect()->route('dashboard.orders.index')->with('success', __('dashboard.order_deleted'));
    }
} 