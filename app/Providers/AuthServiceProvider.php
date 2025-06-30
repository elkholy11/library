<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Order;
use App\Policies\OrderPolicy;
use App\Models\Borrow;
use App\Policies\BorrowPolicy;
use App\Models\BookRequest;
use App\Policies\BookRequestPolicy;
use App\Policies\AuthorPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Order::class => OrderPolicy::class,
        Borrow::class => BorrowPolicy::class,
        BookRequest::class => BookRequestPolicy::class,
        'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Author' => 'App\Policies\AuthorPolicy',
        'App\Models\Category' => 'App\Policies\CategoryPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
