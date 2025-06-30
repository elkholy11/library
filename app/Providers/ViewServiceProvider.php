<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\BookFormDataComposer;
use App\Http\View\Composers\UserListComposer;
use App\Http\View\Composers\OrderFormDataComposer;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(
            ['books.create', 'books.edit'],
            BookFormDataComposer::class
        );

        View::composer(
            ['borrows.create', 'borrows.edit', 'book_requests.create', 'book_requests.edit'],
            UserListComposer::class
        );

        View::composer(
            ['orders.create'],
            OrderFormDataComposer::class
        );
    }
}
