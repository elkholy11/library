<?php

namespace App\Policies;

use App\Models\Borrow;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BorrowPolicy
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
    public function view(User $user, Borrow $borrow): bool
    {
        return $user->id === $borrow->user_id;
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
    public function update(User $user, Borrow $borrow): bool
    {
        // السماح لصاحب الاستعارة أو الأدمن فقط
        return $user->id === $borrow->user_id || ($user->role ?? null) === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Borrow $borrow): bool
    {
        return false; // Not allowed via API
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Borrow $borrow): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Borrow $borrow): bool
    {
        return false;
    }
}
