@php
    $adminName = auth()->user()->name ?? 'Administrator';
    $roomTotal = array_sum($roomStatus ?? []);
    $bookingLabels = $recentBookings->pluck('created_at')->map(fn ($date) => optional($date)->format('M d'))->reverse()->values();
    $bookingValues = $recentBookings->pluck('total_price')->map(fn ($value) => (float) ($value ?? 0))->reverse()->values();
    $roomLabels = collect($roomStatus)->keys()->map(fn ($status) => ucfirst(str_replace('_', ' ', $status)))->values();
    $roomValues = collect($roomStatus)->values();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>Hotel Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/soft-ui-dashboard-tailwind.css?v=1.0.5') }}" rel="stylesheet">
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
                @php
                    $links = [
                        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'ni-shop'],
                        ['label' => 'Bookings', 'route' => 'admin.bookings.index', 'icon' => 'ni-calendar-grid-58'],
                        ['label' => 'Rooms', 'route' => 'admin.rooms.index', 'icon' => 'ni-building'],
                        ['label' => 'Room Types', 'route' => 'admin.room-types.index', 'icon' => 'ni-app'],
                        ['label' => 'Payments', 'route' => 'admin.payments.index', 'icon' => 'ni-credit-card'],
                        ['label' => 'Users', 'route' => 'admin.users.index', 'icon' => 'ni-single-02'],
                        ['label' => 'Messages', 'route' => 'admin.contact-messages.index', 'icon' => 'ni-email-83'],
                        ['label' => 'Testimonials', 'route' => 'admin.testimonials.index', 'icon' => 'ni-chat-round'],
                        ['label' => 'Home Slideshow', 'route' => 'admin.hero-slides.index', 'icon' => 'ni-image'],
                        ['label' => 'About Page', 'route' => 'admin.about-page.index', 'icon' => 'ni-single-copy-04'],
                        ['label' => 'Services Page', 'route' => 'admin.service-page.index', 'icon' => 'ni-settings-gear-65'],
                        ['label' => 'Footer', 'route' => 'admin.footer-page.index', 'icon' => 'ni-world-2'],
                    ];
                @endphp

                @foreach ($links as $link)
                    @php $active = request()->routeIs($link['route']); @endphp
                    <li class="mt-0.5 w-full">
                        <a class="{{ $active ? 'shadow-soft-xl bg-white font-semibold text-slate-700' : '' }} py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors" href="{{ route($link['route']) }}">
                            <div class="{{ $active ? 'bg-gradient-to-tl from-purple-700 to-pink-500 text-white' : 'bg-white text-slate-700' }} shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center">
                                <i class="ni {{ $link['icon'] }} text-sm"></i>
                            </div>
                            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">{{ $link['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="mx-4 mt-8 mb-4">
            <a href="{{ route('logout') }}" class="inline-block w-full px-6 py-3 mb-0 font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer text-xs bg-gradient-to-tl from-slate-600 to-slate-300 hover:scale-102"
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
                        <li class="text-sm pl-2 capitalize leading-normal text-slate-700 before:float-left before:pr-2 before:text-gray-600 before:content-['/']">Dashboard</li>
                    </ol>
                    <h6 class="mb-0 font-bold capitalize">Dashboard</h6>
                </div>
                <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
                    <div class="flex items-center md:ml-auto md:pr-4">
                        <span class="hidden sm:inline text-sm font-semibold text-slate-700">{{ $adminName }}</span>
                        <span class="ml-3 inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-tl from-purple-700 to-pink-500 text-sm font-bold text-white">{{ strtoupper(substr($adminName, 0, 1)) }}</span>
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

            <div class="flex flex-wrap -mx-3">
                @foreach ([
                    ['label' => 'Total Revenue', 'value' => '$' . number_format($stats['revenue'] ?? 0, 2), 'icon' => 'ni-money-coins'],
                    ['label' => 'Bookings', 'value' => number_format($stats['bookings'] ?? 0), 'icon' => 'ni-calendar-grid-58'],
                    ['label' => "Today's Arrivals", 'value' => number_format($stats['today_arrivals'] ?? 0), 'icon' => 'ni-pin-3'],
                    ['label' => "Today's Check-outs", 'value' => number_format($stats['today_checkouts'] ?? 0), 'icon' => 'ni-user-run'],
                    ['label' => 'Paid Payments', 'value' => number_format($recentPayments->count()), 'icon' => 'ni-credit-card'],
                    ['label' => 'Occupied Rooms', 'value' => number_format($stats['occupied_rooms'] ?? 0), 'icon' => 'ni-building'],
                    ['label' => 'Available Rooms', 'value' => number_format($stats['available_rooms'] ?? 0), 'icon' => 'ni-building'],
                    ['label' => 'Unread Messages', 'value' => number_format($stats['unread_messages'] ?? 0), 'icon' => 'ni-email-83'],
                ] as $card)
                    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 xl:w-1/4">
                        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                            <div class="flex-auto p-4">
                                <div class="flex flex-row -mx-3">
                                    <div class="flex-none w-2/3 max-w-full px-3">
                                        <p class="mb-0 font-sans font-semibold leading-normal text-sm">{{ $card['label'] }}</p>
                                        <h5 class="mb-0 font-bold">{{ $card['value'] }}</h5>
                                    </div>
                                    <div class="px-3 text-right basis-1/3">
                                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                                            <i class="ni {{ $card['icon'] }} leading-none text-lg relative top-3.5 text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex flex-wrap mt-6 -mx-3">
                <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-5/12">
                    <div class="relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 bg-white shadow-soft-xl">
                        <div class="flex-auto p-4">
                            <div class="py-4 pr-1 mb-4 bg-gradient-to-tl from-gray-900 to-slate-800 rounded-xl">
                                <canvas id="chart-bars" height="170"></canvas>
                            </div>
                            <h6 class="mt-6 mb-0 ml-2">Room status</h6>
                            <p class="ml-2 leading-normal text-sm"><span class="font-bold">{{ $roomTotal }}</span> rooms tracked</p>
                        </div>
                    </div>
                </div>

                <div class="w-full max-w-full px-3 mt-0 lg:w-7/12">
                    <div class="relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 bg-white shadow-soft-xl">
                        <div class="mb-0 rounded-t-2xl bg-white p-6 pb-0">
                            <h6>Revenue overview</h6>
                            <p class="leading-normal text-sm">Recent booking totals</p>
                        </div>
                        <div class="flex-auto p-4">
                            <canvas id="chart-line" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap my-6 -mx-3">
                <div class="w-full max-w-full px-3 mb-6 lg:w-2/3">
                    <div class="relative flex min-w-0 flex-col break-words rounded-2xl border-0 bg-white shadow-soft-xl">
                        <div class="p-6 pb-0">
                            <h6>Recent bookings</h6>
                            <p class="mb-0 leading-normal text-sm">Paid bookings only</p>
                        </div>
                        <div class="flex-auto px-0 pt-0 pb-2">
                            <div class="p-0 overflow-x-auto">
                                <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                                    <thead class="align-bottom">
                                        <tr>
                                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b text-xxs border-b-gray-200 text-slate-400 opacity-70">Guest</th>
                                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b text-xxs border-b-gray-200 text-slate-400 opacity-70">Room</th>
                                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b text-xxs border-b-gray-200 text-slate-400 opacity-70">Status</th>
                                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b text-xxs border-b-gray-200 text-slate-400 opacity-70">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentBookings as $booking)
                                            <tr>
                                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap">
                                                    <div class="px-4 py-1">
                                                        <h6 class="mb-0 leading-normal text-sm">{{ $booking->user->name ?? 'Guest' }}</h6>
                                                        <p class="mb-0 leading-tight text-xs text-slate-400">{{ optional($booking->created_at)->format('M d, Y') }}</p>
                                                    </div>
                                                </td>
                                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap">
                                                    <p class="mb-0 font-semibold leading-tight text-xs">{{ $booking->room->room_number ?? 'N/A' }}</p>
                                                </td>
                                                <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap">
                                                    <span class="bg-gradient-to-tl from-slate-600 to-slate-300 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">{{ str_replace('_', ' ', $booking->status) }}</span>
                                                </td>
                                                <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap">
                                                    <span class="font-semibold leading-tight text-xs">${{ number_format($booking->total_price ?? 0, 2) }}</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="p-6 text-center text-sm text-slate-400">No recent bookings yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 lg:w-1/3">
                    <div class="relative flex min-w-0 flex-col break-words rounded-2xl border-0 bg-white shadow-soft-xl">
                        <div class="p-6 pb-0">
                            <h6>Admin activity</h6>
                            <p class="leading-normal text-sm">{{ $stats['users'] ?? 0 }} users, {{ $stats['maintenance_rooms'] ?? 0 }} rooms in maintenance</p>
                        </div>
                        <div class="flex-auto p-4">
                            @forelse ($messages as $message)
                                <div class="relative mb-4 flex items-start">
                                    <span class="mt-1 mr-3 h-2.5 w-2.5 rounded-full bg-gradient-to-tl from-blue-600 to-cyan-400"></span>
                                    <div>
                                        <h6 class="mb-1 text-sm font-semibold leading-normal">{{ $message->name ?? 'New message' }}</h6>
                                        <p class="mb-0 text-xs leading-tight text-slate-400">{{ \Illuminate\Support\Str::limit($message->message ?? $message->subject ?? '', 70) }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="mb-4 text-sm text-slate-400">No unread messages.</p>
                            @endforelse

                            <hr class="h-px my-4 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent">

                            @forelse ($recentPayments as $payment)
                                <div class="mb-3 flex items-center justify-between">
                                    <span class="text-sm">Payment #{{ $payment->id }}</span>
                                    <strong class="text-sm text-slate-700">${{ number_format($payment->amount ?? 0, 2) }}</strong>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400">No recent payments.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <script>
        const roomLabels = @json($roomLabels);
        const roomValues = @json($roomValues);
        const bookingLabels = @json($bookingLabels);
        const bookingValues = @json($bookingValues);

        const roomChart = document.getElementById('chart-bars');
        if (roomChart) {
            new Chart(roomChart.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: roomLabels.length ? roomLabels : ['Rooms'],
                    datasets: [{
                        label: 'Rooms',
                        backgroundColor: '#fff',
                        borderRadius: 4,
                        borderSkipped: false,
                        data: roomValues.length ? roomValues : [0],
                        maxBarThickness: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { grid: { display: false }, ticks: { color: '#fff', beginAtZero: true } },
                        x: { grid: { display: false }, ticks: { color: '#fff' } }
                    }
                }
            });
        }

        const revenueChart = document.getElementById('chart-line');
        if (revenueChart) {
            const ctx = revenueChart.getContext('2d');
            const gradient = ctx.createLinearGradient(0, 230, 0, 50);
            gradient.addColorStop(1, 'rgba(203,12,159,0.2)');
            gradient.addColorStop(0.2, 'rgba(72,72,176,0.0)');
            gradient.addColorStop(0, 'rgba(203,12,159,0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: bookingLabels.length ? bookingLabels : ['Today'],
                    datasets: [{
                        label: 'Revenue',
                        tension: 0.4,
                        pointRadius: 0,
                        borderColor: '#cb0c9f',
                        borderWidth: 3,
                        backgroundColor: gradient,
                        fill: true,
                        data: bookingValues.length ? bookingValues : [0]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { grid: { borderDash: [5, 5] }, ticks: { color: '#b2b9bf' } },
                        x: { grid: { display: false }, ticks: { color: '#b2b9bf' } }
                    }
                }
            });
        }
    </script>
    <script src="{{ asset('assets/js/soft-ui-dashboard-tailwind.js?v=1.0.5') }}"></script>
</body>
</html>
