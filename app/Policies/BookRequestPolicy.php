<?php

namespace App\Policies;

use App\Models\BookRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BookRequest $bookRequest): bool
    {
        return $user->id === $bookRequest->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BookRequest $bookRequest): bool
    {
        // يسمح فقط لصاحب الطلب أو الأدمن بالتعديل
        return $user->id === $bookRequest->user_id || ($user->is_admin ?? false);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BookRequest $bookRequest): bool
    {
        // User can delete their own book request only if it is still pending.
        return $user->id === $bookRequest->user_id && $bookRequest->status === 'pending';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BookRequest $bookRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BookRequest $bookRequest): bool
    {
        return false;
    }
} 