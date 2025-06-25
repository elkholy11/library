<header class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container-fluid">
        <!-- Sidebar Toggle Button -->
        <button class="btn btn-outline-secondary" type="button" id="sidebar-toggle">
            <i class="fa fa-bars"></i>
        </button>
        
        <div class="ms-auto d-flex align-items-center">
            <!-- Language Switcher -->
            <div class="dropdown me-3">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownLang" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-globe"></i> {{ app()->getLocale() == 'ar' ? __('dashboard.arabic') : __('dashboard.english') }}
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownLang">
                    <li><a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">English</a></li>
                    <li><a class="dropdown-item" href="{{ route('lang.switch', 'ar') }}">العربية</a></li>
                </ul>
            </div>

            <!-- User Dropdown -->
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-user"></i> {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                    <li><a class="dropdown-item" href="{{ route('dashboard.profile.show') }}">@lang('dashboard.profile')</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">@lang('dashboard.logout')</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header> 