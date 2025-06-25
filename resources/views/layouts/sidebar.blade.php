<div class="sidebar" id="sidebarMenu">
    <h3 class="text-white text-center my-3">Library MS</h3>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
                <i class="fa fa-tachometer-alt fa-fw"></i> @lang('dashboard.home')
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard.books.*') ? 'active' : '' }}" href="{{ route('dashboard.books.index') }}">
                <i class="fa fa-book fa-fw"></i> @lang('dashboard.books')
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard.authors.*') ? 'active' : '' }}" href="{{ route('dashboard.authors.index') }}">
                <i class="fa fa-feather-alt fa-fw"></i> @lang('dashboard.authors')
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard.categories.*') ? 'active' : '' }}" href="{{ route('dashboard.categories.index') }}">
                <i class="fa fa-layer-group fa-fw"></i> @lang('dashboard.categories')
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard.users.*') ? 'active' : '' }}" href="{{ route('dashboard.users.index') }}">
                <i class="fa fa-users fa-fw"></i> @lang('dashboard.users')
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard.borrows.*') ? 'active' : '' }}" href="{{ route('dashboard.borrows.index') }}">
                <i class="fa fa-hand-holding-heart fa-fw"></i> @lang('dashboard.borrows')
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard.book_requests.*') ? 'active' : '' }}" href="{{ route('dashboard.book_requests.index') }}">
                <i class="fa fa-inbox fa-fw"></i> @lang('dashboard.book_requests')
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard.orders.*') ? 'active' : '' }}" href="{{ route('dashboard.orders.index') }}">
                <i class="fa fa-shopping-cart fa-fw"></i> @lang('dashboard.orders')
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard.profile.*') ? 'active' : '' }}" href="{{ route('dashboard.profile.show') }}">
                <i class="fa fa-user fa-fw"></i> @lang('dashboard.profile')
            </a>
        </li>
    </ul>
</div> 