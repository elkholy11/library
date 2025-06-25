<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Requests\Order\UpdateRequest;
use App\Http\Requests\Order\DashboardStoreRequest;
use App\Models\Book;
use App\Models\User;
use App\Services\OrderService;
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
        $orders = Order::with('user', 'books')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    // Creating orders from dashboard is disabled
    public function create()
    {
        $users = User::where('role', 'user')->get();
        $books = Book::where('status', 'available')->where('available_quantity', '>', 0)->get();
        return view('orders.create', compact('users', 'books'));
    }

    public function store(DashboardStoreRequest $request)
    {
        $this->orderService->createOrderFromDashboard($request->validated());

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
        $validated = $request->validated();
        $oldStatus = $order->status;
        
        if ($oldStatus === 'pending' && $validated['status'] === 'rejected') {
            DB::transaction(function () use ($order, $validated) {
                // Return the books to stock
                foreach ($order->books as $book) {
                    Book::find($book->id)->increment('available_quantity', $book->pivot->quantity);
                }
                $order->update($validated);
            });
        } else {
            $order->update($validated);
        }

        return redirect()->route('dashboard.orders.index')->with('success', __('dashboard.order_updated'));
    }

    public function destroy(Order $order)
    {
        // If order is not pending, we should not return books to stock
        // because they are either delivered or cancelled (and stock already adjusted).
        if ($order->status === 'pending') {
             DB::transaction(function () use ($order) {
                // Return the books to stock
                foreach ($order->books as $book) {
                    Book::find($book->id)->increment('available_quantity', $book->pivot->quantity);
                }
                $order->delete();
            });
        } else {
            $order->delete();
        }

        return redirect()->route('dashboard.orders.index')->with('success', __('dashboard.order_deleted'));
    }
} 