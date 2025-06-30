<?php

namespace App\Http\View\Composers;

use App\Models\User;
use App\Models\Book;
use Illuminate\View\View;

class OrderFormDataComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'users' => User::where('role', 'user')->get(),
            'books' => Book::where('status', 'available')->where('available_quantity', '>', 0)->get(),
        ]);
    }
} 