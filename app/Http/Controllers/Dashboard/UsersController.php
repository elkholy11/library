<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use Illuminate\Support\Facades\Hash;
use App\Services\Dashboard\UserService;

class UsersController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->listUsers();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(StoreRequest $request)
    {
        $this->userService->createUser($request->validated());
        return redirect()->route('dashboard.users.index')->with('success', __('dashboard.user_created'));
    }

    public function show(User $user)
    {
        $user = $this->userService->showUser($user);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UpdateRequest $request, User $user)
    {
        $this->userService->updateUser($user, $request->validated());
        return redirect()->route('dashboard.users.index')->with('success', __('dashboard.user_updated'));
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $this->userService->deleteUser($user);
        return redirect()->route('dashboard.users.index')->with('success', __('dashboard.user_deleted'));
    }
} 