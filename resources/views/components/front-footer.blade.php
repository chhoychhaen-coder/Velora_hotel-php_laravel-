<footer class="front-footer wow fadeIn mt-5" data-wow-delay="0.1s">
    <div class="container">
        <div class="front-footer-main">
            <div class="row g-4 align-items-start">
                <div class="col-lg-4">
                    <a href="{{ route('home') }}" class="front-footer-brand">
                        <span>{{ $footerSetting?->brand_name ?? 'Velora Hotel' }}</span>
                    </a>
                    <p class="front-footer-copy">{{ $footerSetting?->tagline ?? 'Comfortable rooms, simple booking, and responsive service for every guest.' }}</p>
                    @if(($footerSocialLinks ?? collect())->isNotEmpty())
                        <div class="front-social-links">
                            @foreach($footerSocialLinks as $social)
                                <a href="{{ $social->resolvedUrl() ?? '#' }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social->label }}">
                                    <i class="{{ $social->iconClass() }}"></i>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="front-social-links">
                            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        </div>
                    @endif
                </div>

                <div class="col-sm-6 col-lg-2">
                    <h6 class="front-footer-title">{{ $footerSetting?->company_section_title ?? 'Company' }}</h6>
                    <a class="front-footer-link" href="{{ route('about') }}">About</a>
                    <a class="front-footer-link" href="{{ route('service') }}">Services</a>
                    <a class="front-footer-link" href="{{ route('rooms') }}">Rooms</a>
                    <a class="front-footer-link" href="{{ route('contact') }}">Contact</a>
                </div>

                <div class="col-sm-6 col-lg-2">
                    <h6 class="front-footer-title">{{ $footerSetting?->guest_section_title ?? 'Guest' }}</h6>
                    <a class="front-footer-link" href="{{ route('booking') }}">Booking</a>
                    @auth
                        <a class="front-footer-link" href="{{ route('bookings.mine') }}">My Bookings</a>
                    @else
                        <a class="front-footer-link" href="{{ route('login') }}">Login</a>
                        @if(Route::has('register'))
                            <a class="front-footer-link" href="{{ route('register') }}">Sign Up</a>
                        @endif
                    @endauth
                </div>

                <div class="col-lg-4">
                    <h6 class="front-footer-title">{{ $footerSetting?->contact_section_title ?? 'Contact' }}</h6>
                    <div class="front-contact-list">
                        @if($footerSetting?->address)
                            <p><i class="fa fa-map-marker-alt"></i><span>{{ $footerSetting->address }}</span></p>
                        @endif
                        @if($footerSetting?->phone)
                            <p><i class="fa fa-phone-alt"></i><span>{{ $footerSetting->phone }}</span></p>
                        @endif
                        @if($footerSetting?->email)
                            <p><i class="fa fa-envelope"></i><span>{{ $footerSetting->email }}</span></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="front-footer-bottom">
            <span>&copy; {{ date('Y') }} {{ $footerSetting?->copyright_text ?? 'Velora Hotel. All rights reserved.' }}</span>
            <a href="{{ route('home') }}">Back to home</a>
        </div>
    </div>
</footer>