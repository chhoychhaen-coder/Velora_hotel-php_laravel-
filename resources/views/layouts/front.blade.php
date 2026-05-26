<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Velora Hotel')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('fronend/hotelier-1.0.0/img/favicon.ico') }}" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="{{ asset('fronend/hotelier-1.0.0/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('fronend/hotelier-1.0.0/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('fronend/hotelier-1.0.0/css/style.css') }}" rel="stylesheet">
    @php
        $frontCssPath = resource_path('css/front.css');
        $frontCssVersion = is_file($frontCssPath) ? filemtime($frontCssPath) : time();
    @endphp
    <link href="{{ route('assets.front.css') }}?v={{ $frontCssVersion }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="front-site">
    <div class="front-site-wrap">
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <x-front-navbar />

        @if(session('success'))
            <div class="container front-alert-wrap">
                <div class="alert alert-success mb-0">{{ session('success') }}</div>
            </div>
        @endif

        <main class="front-main">
            @yield('content')
        </main>

        <x-front-footer />
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('fronend/hotelier-1.0.0/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('fronend/hotelier-1.0.0/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('fronend/hotelier-1.0.0/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('fronend/hotelier-1.0.0/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('fronend/hotelier-1.0.0/js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
