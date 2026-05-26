<!-- Header Start -->
<div class="container-fluid bg-dark px-0">
    <div class="row gx-0">
        <div class="col-lg-3 bg-dark d-none d-lg-block">
            <a href="{{ route('home') }}" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                <h1 class="m-0 text-primary text-uppercase">Velora</h1>
            </a>
        </div>
        <div class="col-lg-9">
            <div class="row gx-0 bg-white d-none d-lg-flex">
                <div class="col-lg-7 px-5 text-start">
                    <div class="h-100 d-inline-flex align-items-center py-2 me-4">
                        <i class="fa fa-envelope text-primary me-2"></i>
                        <p class="mb-0">info@velorahotel.com</p>
                    </div>
                    <div class="h-100 d-inline-flex align-items-center py-2">
                        <i class="fa fa-phone-alt text-primary me-2"></i>
                        <p class="mb-0">+1 234 567 8900</p>
                    </div>
                </div>
                <div class="col-lg-5 px-5 text-end">
                    <div class="d-inline-flex align-items-center py-2">
                        <a class="me-3" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="me-3" href=""><i class="fab fa-twitter"></i></a>
                        <a class="me-3" href=""><i class="fab fa-linkedin-in"></i></a>
                        <a class="me-3" href=""><i class="fab fa-instagram"></i></a>
                        <a class="" href=""><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0">
                <a href="{{ route('home') }}" class="navbar-brand d-block d-lg-none">
                    <h1 class="m-0 text-primary text-uppercase">Velora</h1>
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="{{ route('home') }}" class="nav-item nav-link @if(Route::current()->getName() === 'home') active @endif">Home</a>
                        <a href="{{ route('about') }}" class="nav-item nav-link @if(Route::current()->getName() === 'about') active @endif">About</a>
                        <a href="{{ route('service') }}" class="nav-item nav-link @if(Route::current()->getName() === 'service') active @endif">Services</a>
                        <a href="{{ route('rooms') }}" class="nav-item nav-link @if(Route::current()->getName() === 'rooms') active @endif">Rooms</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="{{ route('booking') }}" class="dropdown-item @if(Route::current()->getName() === 'booking') active @endif">Booking</a>
                                <a href="{{ route('team') }}" class="dropdown-item @if(Route::current()->getName() === 'team') active @endif">Our Team</a>
                                <a href="{{ route('testimonial') }}" class="dropdown-item @if(Route::current()->getName() === 'testimonial') active @endif">Testimonial</a>
                            </div>
                        </div>
                        <a href="{{ route('contact') }}" class="nav-item nav-link @if(Route::current()->getName() === 'contact') active @endif">Contact</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Header End -->
