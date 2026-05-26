@php
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
    $isAuthenticated = auth()->check();
@endphp

@if($isAdmin)
    <a href="{{ route('admin.dashboard') }}" class="nav-item nav-link d-lg-none">Admin</a>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Admin<i class="fa fa-arrow-right ms-2"></i></a>
@elseif($isAuthenticated)
    <form method="POST" action="{{ route('logout') }}" class="d-lg-none front-auth-form">
        @csrf
        <button type="submit">Logout</button>
    </form>
    <form method="POST" action="{{ route('logout') }}" class="m-0">
        @csrf
        <button type="submit" class="btn btn-primary">Logout<i class="fa fa-arrow-right ms-2"></i></button>
    </form>
@else
    <a href="{{ route('login') }}" class="nav-item nav-link d-lg-none">Login</a>
    @if(Route::has('register'))
        <a href="{{ route('register') }}" class="nav-item nav-link d-lg-none">Register</a>
    @endif
    <a href="{{ route('login') }}" class="btn btn-outline-light">Login</a>
    @if(Route::has('register'))
        <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
    @endif
@endif
