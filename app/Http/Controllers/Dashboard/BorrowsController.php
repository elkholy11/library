<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\User;
use App\Models\Book;
use App\Http\Requests\Borrow\DashboardStoreRequest;
use App\Http\Requests\Borrow\UpdateRequest;
use App\Services\BorrowService;

class BorrowsController extends Controller
{
    protected $borrowService;

    public function __construct(BorrowService $borrowService)
    {
        $this->borrowService = $borrowService;
    }

    public function index()
    {
        $borrows = Borrow::with('user', 'book')->latest()->paginate(10);
        return view('borrows.index', compact('borrows'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->get();
        $books = Book::where('available_quantity', '>', 0)->get();
        return view('borrows.create', compact('users', 'books'));
    }

    public function store(DashboardStoreRequest $request)
    {
        $this->borrowService->createBorrowFromDashboard($request->validated());

        return redirect()->route('dashboard.borrows.index')->with('success', __('dashboard.borrow_created'));
    }

    public function show(Borrow $borrow)
    {
        return view('borrows.show', compact('borrow'));
    }

    public function edit(Borrow $borrow)
    {
        $users = User::where('role', 'user')->get();
        $books = Book::all(); // Get all books for the dropdown
        return view('borrows.edit', compact('borrow', 'users', 'books'));
    }

    public function update(UpdateRequest $request, Borrow $borrow)
    {
        $data = $request->validated();
        $isReturning = $data['status'] === 'returned' && $borrow->status === 'borrowed';

        $borrow->update($data);

        // If the book is being returned, increment its available quantity
        if ($isReturning) {
            $borrow->book->increment('available_quantity');
            if(empty($data['returned_at'])) {
                $borrow->update(['returned_at' => now()]);
            }
        }

        return redirect()->route('dashboard.borrows.index')->with('success', __('dashboard.borrow_updated'));
    }

    public function destroy(Borrow $borrow)
    {
        // If a borrow record is deleted and the book was not returned,
        // we should probably increment the book's available quantity.
        if ($borrow->status === 'borrowed') {
            $borrow->book->increment('available_quantity');
        }

        $borrow->delete();
        return redirect()->route('dashboard.borrows.index')->with('success', __('dashboard.borrow_deleted'));
    }
} 