<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\User;
use App\Models\Book;
use App\Http\Requests\Borrow\DashboardStoreRequest;
use App\Http\Requests\Borrow\UpdateRequest;
use App\Services\Dashboard\BorrowService;

class BorrowsController extends Controller
{
    protected $borrowService;

    public function __construct(BorrowService $borrowService)
    {
        $this->borrowService = $borrowService;
    }

    public function index()
    {
        $borrows = $this->borrowService->listBorrows();
        return view('borrows.index', compact('borrows'));
    }

    public function create()
    {
        $books = Book::where('available_quantity', '>', 0)->get();
        return view('borrows.create', compact('books'));
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
        $books = Book::all();
        return view('borrows.edit', compact('borrow', 'books'));
    }

    public function update(UpdateRequest $request, Borrow $borrow)
    {
        $this->borrowService->updateBorrow($borrow, $request->validated());
        return redirect()->route('dashboard.borrows.index')->with('success', __('dashboard.borrow_updated'));
    }

    public function destroy(Borrow $borrow)
    {
        $this->borrowService->deleteBorrow($borrow);
        return redirect()->route('dashboard.borrows.index')->with('success', __('dashboard.borrow_deleted'));
    }
} 