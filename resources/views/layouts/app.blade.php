<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', __('dashboard.title'))</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/custom.css">
    <script src="/js/custom.js" defer></script>
    <style>
        body { font-family: 'Cairo', 'Arial', sans-serif; }
    </style>
</head>
<body>
    @php
        $hideNavbar = in_array(Route::currentRouteName(), ['login', 'register']);
        $isAdmin = auth()->check() && optional(auth()->user())->role === 'admin';
        $isUser = auth()->check() && optional(auth()->user())->role === 'user';
    @endphp
    <div id="app" class="app-container">

        @unless(request()->routeIs('dashboard'))
            @include('layouts.sidebar')
        @endunless

        <div class="main-content">
            <nav class="navbar">
                <div class="navbar-left">
                    <button class="sidebar-toggle" id="sidebar-toggle"><i class="fas fa-bars"></i></button>
                    <div class="lang-switcher-container">
                        @if(app()->getLocale() == 'ar')
                            <a href="{{ route('lang.switch', 'en') }}" class="lang-link">
                                <i class="fas fa-globe"></i> English
                            </a>
                        @else
                            <a href="{{ route('lang.switch', 'ar') }}" class="lang-link">
                                <i class="fas fa-globe"></i> العربية
                            </a>
                        @endif
                    </div>
                </div>
                <div class="navbar-user">
                    @auth
                        <div class="user-dropdown">
                            <button class="user-dropdown-toggle">
                                {{ auth()->user()->name }} <span class="arrow">▼</span>
                            </button>
                            <div class="user-dropdown-menu">
                                <a href="{{ route('dashboard.profile.show') }}">@lang('dashboard.profile')</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary w-full">
                                        @lang('تسجيل الخروج')
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </nav>
            <main class="content-body">
                <div class="container mx-auto p-4">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <div class="auth-wrapper">
        @yield('content')
    </div>
</body>
</html> 