<?php

namespace App\Services\Dashboard;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileService
{
    public function getProfile()
    {
        return Auth::user();
    }

    public function updateProfile($user, array $validatedData)
    {
        $userData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ];
        if (!empty($validatedData['password'])) {
            $userData['password'] = Hash::make($validatedData['password']);
        }
        $user->update($userData);
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'bio' => $validatedData['bio'],
            ]
        );
        return $user;
    }
} 