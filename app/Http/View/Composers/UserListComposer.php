<?php

namespace App\Http\View\Composers;

use App\Models\User;
use Illuminate\View\View;

class UserListComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('users', User::where('role', 'user')->get());
    }
} 