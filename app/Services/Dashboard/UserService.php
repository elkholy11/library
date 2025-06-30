<?php

namespace App\Services\Dashboard;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function listUsers()
    {
        return User::latest()->paginate(10);
    }

    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function updateUser(User $user, array $data)
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        return $user;
    }

    public function deleteUser(User $user)
    {
        $user->delete();
    }

    public function showUser(User $user)
    {
        $user->load('profile');
        return $user;
    }
} 