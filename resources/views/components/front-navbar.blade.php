@php
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
    $isAuthenticated = auth()->check();
@endphp

<header class="front-navbar-shell">
    <nav class="navbar navbar-expand-lg navbar-dark front-navbar">
        <a href="{{ route('home') }}" class="navbar-brand front-brand">
            <span class="front-brand-text">Velora</span>
        </a>

        <button type="button" class="navbar-toggler front-navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse front-navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav front-nav-links">
                <a href="{{ route('home') }}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('about') }}" class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
                <a href="{{ route('service') }}" class="nav-item nav-link {{ request()->routeIs('service') ? 'active' : '' }}">Services</a>
                <a href="{{ route('rooms') }}" class="nav-item nav-link {{ request()->routeIs('rooms') ? 'active' : '' }}">Rooms</a>
                <a href="{{ route('booking') }}" class="nav-item nav-link {{ request()->routeIs('booking') ? 'active' : '' }}">Booking</a>
                @auth
                    <a href="{{ route('bookings.mine') }}" class="nav-item nav-link {{ request()->routeIs('bookings.mine') ? 'active' : '' }}">My Bookings</a>
                @endauth
                <a href="{{ route('contact') }}" class="nav-item nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
            </div>

            <div class="front-auth-actions">
                @if($isAdmin)
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Admin<i class="fa fa-arrow-right ms-2"></i></a>
                @elseif($isAuthenticated)
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout<i class="fa fa-arrow-right ms-2"></i></button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light">Login</a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                    @endif
                @endif
            </div>
        </div>
    </nav>
</header>
