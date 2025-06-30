<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\UserAuthResource;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register a new user.
     */
    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request);
        return new UserAuthResource($result['user'], $result['token']);
    }

    /**
     * Login user and create token.
     */
    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request);
        if (!$result) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }
        return new UserAuthResource($result['user'], $result['token']);
    }

    /**
     * Logout user (Revoke the token).
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
} 