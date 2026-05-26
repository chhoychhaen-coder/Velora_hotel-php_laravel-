@php
    $adminName = auth()->user()->name ?? 'Administrator';
    $adminLinks = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'icon' => 'ni-shop'],
        ['label' => 'Bookings', 'route' => 'admin.bookings.index', 'match' => 'admin.bookings.*', 'icon' => 'ni-calendar-grid-58'],
        ['label' => 'Booking Page', 'route' => 'admin.booking-page.index', 'match' => 'admin.booking-page.*|admin.booking-page-images.*', 'icon' => 'ni-image'],
        ['label' => 'Calendar', 'route' => 'admin.calendar', 'match' => 'admin.calendar', 'icon' => 'ni-watch-time'],
        ['label' => 'Booked Rooms', 'route' => 'admin.booked-rooms', 'match' => 'admin.booked-rooms', 'icon' => 'ni-key-25'],
        ['label' => 'Reports', 'route' => 'admin.reports', 'match' => 'admin.reports', 'icon' => 'ni-chart-bar-32'],
        ['label' => 'Rooms', 'route' => 'admin.rooms.index', 'match' => 'admin.rooms.*', 'icon' => 'ni-building'],
        ['label' => 'Room Types', 'route' => 'admin.room-types.index', 'match' => 'admin.room-types.*', 'icon' => 'ni-app'],
        ['label' => 'Payments', 'route' => 'admin.payments.index', 'match' => 'admin.payments.*', 'icon' => 'ni-credit-card'],
        ['label' => 'Users', 'route' => 'admin.users.index', 'match' => 'admin.users.*', 'icon' => 'ni-single-02'],
        ['label' => 'Messages', 'route' => 'admin.contact-messages.index', 'match' => 'admin.contact-messages.*', 'icon' => 'ni-email-83', 'badge' => \App\Models\ContactMessage::where('is_read', false)->count()],
        ['label' => 'Contact Page', 'route' => 'admin.contact-page.index', 'match' => 'admin.contact-page.*|admin.contact-info-items.*', 'icon' => 'ni-mobile-button'],
        ['label' => 'Testimonial', 'route' => 'admin.testimonials.index', 'match' => 'admin.testimonials.*', 'icon' => 'ni-chat-round'],
        ['label' => 'Home Slideshow', 'route' => 'admin.hero-slides.index', 'match' => 'admin.hero-slides.*', 'icon' => 'ni-image'],
        ['label' => 'About Page', 'route' => 'admin.about-page.index', 'match' => 'admin.about-page.*|admin.about-features.*|admin.about-gallery.*', 'icon' => 'ni-single-copy-04'],
        ['label' => 'Services Page', 'route' => 'admin.service-page.index', 'match' => 'admin.service-page.*|admin.service-items.*', 'icon' => 'ni-settings-gear-65'],
        ['label' => 'Footer', 'route' => 'admin.footer-page.index', 'match' => 'admin.footer-page.*|admin.footer-links.*', 'icon' => 'ni-world-2'],
    ];
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/soft-ui-dashboard-tailwind.css?v=1.0.5') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="m-0 font-sans antialiased font-normal text-base leading-default bg-gray-50 text-slate-500">
    <aside class="max-w-62.5 ease-nav-brand z-990 fixed inset-y-0 my-4 ml-4 block w-full flex-wrap items-center justify-between overflow-y-auto rounded-2xl border-0 bg-white p-0 antialiased shadow-soft-xl transition-transform duration-200 xl:left-0 xl:translate-x-0">
        <div class="h-19.5">
            <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap text-slate-700" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('assets/img/logo-ct.png') }}" class="inline h-full max-w-full transition-all duration-200 ease-nav-brand max-h-8" alt="main logo">
                <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Hotel Admin</span>
            </a>
        </div>

        <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent">

        <nav class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
            <ul class="flex flex-col pl-0 mb-0">
                @foreach ($adminLinks as $link)
                    @php $active = request()->routeIs($link['match']); @endphp
                    <li class="mt-0.5 w-full">
                        <a class="{{ $active ? 'shadow-soft-xl bg-white font-semibold text-slate-700' : 'text-slate-700' }} py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors" href="{{ route($link['route']) }}">
                            <div class="{{ $active ? 'bg-gradient-to-tl from-purple-700 to-pink-500 text-white' : 'bg-white text-slate-700' }} shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center">
                                <i class="ni {{ $link['icon'] }} text-sm"></i>
                            </div>
                            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">{{ $link['label'] }}</span>
                            @if (($link['badge'] ?? 0) > 0)
                                <span class="ml-auto inline-flex min-w-5 items-center justify-center rounded-lg bg-gradient-to-tl from-slate-600 to-slate-300 px-2 py-1 text-xs font-bold leading-none text-white">{{ $link['badge'] }}</span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="mx-4 mt-8 mb-4">
            <a href="{{ route('logout') }}"
               class="inline-block w-full px-6 py-3 mb-0 font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer text-xs bg-gradient-to-tl from-slate-600 to-slate-300 hover:scale-102"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" hidden>
                @csrf
            </form>
        </div>
    </aside>

    <main class="ease-soft-in-out xl:ml-68.5 relative h-full min-h-screen rounded-xl transition-all duration-200">
        <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all shadow-none duration-250 ease-soft-in rounded-2xl lg:flex-nowrap lg:justify-start">
            <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
                <div>
                    <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
                        <li class="text-sm leading-normal text-slate-700">Admin</li>
                        <li class="text-sm pl-2 capitalize leading-normal text-slate-700 before:float-left before:pr-2 before:text-gray-600 before:content-['/']">@yield('page_title', 'Dashboard')</li>
                    </ol>
                    <h6 class="mb-0 font-bold capitalize">@yield('page_title', 'Dashboard')</h6>
                </div>

                <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
                    <div class="flex items-center md:ml-auto md:pr-4">
                        <span class="hidden sm:inline text-sm font-semibold text-slate-700">{{ $adminName }}</span>
                        <span class="ml-2 hidden rounded-lg bg-slate-100 px-2 py-1 text-xs font-bold uppercase text-slate-500 sm:inline">
                            {{ auth()->user()->role ?? 'user' }}
                        </span>
                        <span class="ml-3 inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-tl from-purple-700 to-pink-500 text-sm font-bold text-white">
                            {{ strtoupper(substr($adminName, 0, 1)) }}
                        </span>
                    </div>
                </div>
            </div>
        </nav>

        <div class="w-full px-6 py-6 mx-auto">
            @if (session('success'))
                <div class="relative w-full p-4 mb-4 text-white rounded-lg bg-gradient-to-tl from-emerald-500 to-teal-400">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="relative w-full p-4 mb-4 text-white rounded-lg bg-gradient-to-tl from-red-500 to-rose-400">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="relative w-full p-4 mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700">
                    <ul class="mb-0 list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</body>
</html>
