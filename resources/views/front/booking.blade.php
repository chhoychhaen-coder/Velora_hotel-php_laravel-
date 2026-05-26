@extends('layouts.front')

@section('title', 'Booking - Velora Hotel')

@section('content')
@php
    $selectedRoom = $rooms->firstWhere('id', (int) old('room_id', request('room_id'))) ?? $selectedRoom;
    $selectedRoomStatus = $selectedRoom ? ucfirst($selectedRoom->status) : '-';
    $selectedRoomPayload = $selectedRoom ? [
        'id' => $selectedRoom->id,
        'name' => $selectedRoom->roomType->name,
        'room' => $selectedRoom->room_number,
        'price' => $selectedRoom->roomType->price_per_night,
        'adults' => $selectedRoom->roomType->capacity_adults,
        'children' => $selectedRoom->roomType->capacity_children,
        'description' => $selectedRoom->roomType->description ?? 'Comfortable room with modern amenities.',
        'image' => \App\Helpers\HotelAssets::roomImage($selectedRoom->roomType->image_url, 0),
        'status' => $selectedRoom->status,
        'bookable' => $selectedRoom->status === 'available',
    ] : null;
@endphp
<x-front-page-header title="Book Your Room" breadcrumb="Booking" />
<!-- Booking Start -->
<!-- Booking End -->
<!-- Booking Form Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-primary text-uppercase">Book Now</h6>
            <h1 class="mb-5">Book A <span class="text-primary text-uppercase">Luxury Room</span></h1>
            <p class="text-muted mb-0">Your reservation is saved only after payment succeeds.</p>
        </div>

        </div>
        <div class="row g-5">
            <div class="col-lg-6">
                <div class="row g-3">
                    @php
                        $bookingImageFallback = \App\Helpers\HotelAssets::url('about-1.jpg');
                    @endphp
                    @forelse($bookingPageImages as $image)
                        <div class="col-6 {{ $image->align_class }}">
                            <img
                                class="img-fluid rounded {{ $image->size_class }} wow zoomIn"
                                data-wow-delay="{{ number_format(($loop->index + 1) * 0.2, 1) }}s"
                                src="{{ $image->imageUrl() }}"
                                alt="Booking gallery image {{ $loop->iteration }}"
                                @if($image->extra_style) style="{{ $image->extra_style }}" @endif
                                loading="lazy"
                                onerror="this.onerror=null;this.src='{{ $bookingImageFallback }}';"
                            >
                        </div>
                    @empty
                        <div class="col-6 text-end">
                            <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.1s" src="{{ \App\Helpers\HotelAssets::url('about-1.jpg') }}" style="margin-top: 25%;" loading="lazy" alt="">
                        </div>
                        <div class="col-6 text-start">
                            <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.3s" src="{{ \App\Helpers\HotelAssets::url('about-2.jpg') }}" loading="lazy" alt="">
                        </div>
                        <div class="col-6 text-end">
                            <img class="img-fluid rounded w-50 wow zoomIn" data-wow-delay="0.5s" src="{{ \App\Helpers\HotelAssets::url('about-3.jpg') }}" loading="lazy" alt="">
                        </div>
                        <div class="col-6 text-start">
                            <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.7s" src="{{ \App\Helpers\HotelAssets::url('about-4.jpg') }}" loading="lazy" alt="">
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="col-lg-6">
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            @if ($errors->has('room_id'))
                                <strong>Room unavailable.</strong>
                                {{ $errors->first('room_id') }}
                            @else
                                <strong>Please check your booking details.</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endif

                    <form method="POST" action="{{ route('bookings.store') }}" id="customer-booking-form">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Your Name" value="{{ old('name', auth()->user()->name ?? '') }}">
                                    <label for="name">Your Name</label>
                                    @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Your Email" value="{{ old('email', auth()->user()->email ?? '') }}">
                                    <label for="email">Your Email</label>
                                    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control @error('check_in') is-invalid @enderror" id="checkin" name="check_in" placeholder="Check In" value="{{ old('check_in', request('check_in')) }}" min="{{ now()->toDateString() }}" />
                                    <label for="checkin">Check In</label>
                                    @error('check_in')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control @error('check_out') is-invalid @enderror" id="checkout" name="check_out" placeholder="Check Out" value="{{ old('check_out', request('check_out')) }}" min="{{ now()->addDay()->toDateString() }}" />
                                    <label for="checkout">Check Out</label>
                                    @error('check_out')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="front-capacity-box">
                                    <span>Adults</span>
                                    <strong id="booking-adults">{{ $selectedRoom?->roomType?->capacity_adults ?? 'Select room' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="front-capacity-box">
                                    <span>Children</span>
                                    <strong id="booking-children">{{ $selectedRoom?->roomType?->capacity_children ?? 'Select room' }}</strong>
                                </div>
                            </div>
                            <input type="hidden" name="adults" id="booking-adults-input" value="{{ $selectedRoom?->roomType?->capacity_adults }}">
                            <input type="hidden" name="children" id="booking-children-input" value="{{ $selectedRoom?->roomType?->capacity_children }}">
                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-select @error('room_id') is-invalid @enderror" id="select3" name="room_id">
                                        <option value="">Select A Room</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}"
                                                data-price="{{ $room->roomType->price_per_night }}"
                                                data-name="{{ $room->roomType->name }}"
                                                data-room="{{ $room->room_number }}"
                                                data-adults="{{ $room->roomType->capacity_adults }}"
                                                data-children="{{ $room->roomType->capacity_children }}"
                                                data-description="{{ $room->roomType->description ?? 'Comfortable room with modern amenities.' }}"
                                                data-image="{{ \App\Helpers\HotelAssets::roomImage($room->roomType->image_url, $loop->index) }}"
                                                {{ old('room_id', request('room_id')) == $room->id ? 'selected' : '' }}>
                                                {{ $room->roomType->name }} - Room {{ $room->room_number }} (${{ number_format($room->roomType->price_per_night, 2) }}/Night)
                                            </option>
                                        @endforeach

                                    </select>
                                    <label for="select3">Select A Room</label>
                                    @error('room_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                                @if($selectedRoom && $selectedRoom->status !== 'available')
                                    <div class="alert alert-warning mt-3 mb-0">
                                        This room is currently {{ strtolower($selectedRoom->status) }} and cannot be booked now.
                                    </div>
                                @endif
                                <div class="front-unavailable-dates mt-3">
                                    <span>Unavailable dates</span>
                                    <div id="selected-room-unavailable-dates">Select a room to view booked dates.</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div id="booking-availability-alert" class="alert alert-warning mb-0 d-none">
                                    This room is already booked for the selected dates. Please choose another room or change the dates.
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control @error('special_request') is-invalid @enderror" placeholder="Special Request" id="message" name="special_request" style="height: 100px">{{ old('special_request') }}</textarea>
                                    <label for="message">Special Request</label>
                                    @error('special_request')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="bg-light rounded p-4">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-4">
                                            <img id="booking-room-image" class="img-fluid rounded w-100" src="{{ \App\Helpers\HotelAssets::roomImage($selectedRoom?->roomType?->image_url, $selectedRoom?->id ?? 0) }}" alt="Selected room">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Room</span>
                                                <strong id="booking-room-name">{{ $selectedRoom ? $selectedRoom->roomType->name . ' - Room ' . $selectedRoom->room_number : 'Select a room' }}</strong>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Nights</span>
                                                <strong id="booking-nights">0</strong>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Nightly rate</span>
                                                <strong id="booking-rate">$0.00</strong>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Room capacity</span>
                                                <strong id="booking-capacity">Select a room</strong>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between fs-5">
                                                <span>Total estimate</span>
                                                <strong class="text-primary" id="booking-total">$0.00</strong>
                                            </div>
                                            <small class="text-muted d-block mt-2">Bookings are created only after successful payment. Taxes and extra service fees are not included.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" id="booking-submit" type="submit">Continue to Payment</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Booking Form End -->

<script>
    const roomBookings = @json($roomBookings);
    const initialSelectedRoom = @json($selectedRoomPayload);
    const bookingForm = document.getElementById('customer-booking-form');
    const roomSelect = document.getElementById('select3');
    const checkInInput = document.getElementById('checkin');
    const checkOutInput = document.getElementById('checkout');
    const availabilityAlert = document.getElementById('booking-availability-alert');
    const bookingSubmit = document.getElementById('booking-submit');
    const roomName = document.getElementById('booking-room-name');
    const roomImage = document.getElementById('booking-room-image');
    const nightsLabel = document.getElementById('booking-nights');
    const rateLabel = document.getElementById('booking-rate');
    const totalLabel = document.getElementById('booking-total');
    const adultsLabel = document.getElementById('booking-adults');
    const childrenLabel = document.getElementById('booking-children');
    const adultsInput = document.getElementById('booking-adults-input');
    const childrenInput = document.getElementById('booking-children-input');
    const capacityLabel = document.getElementById('booking-capacity');
    const selectedRoomDetailImage = document.getElementById('selected-room-detail-image');
    const selectedRoomDetailName = document.getElementById('selected-room-detail-name');
    const selectedRoomDetailDescription = document.getElementById('selected-room-detail-description');
    const selectedRoomDetailRate = document.getElementById('selected-room-detail-rate');
    const selectedRoomDetailCapacity = document.getElementById('selected-room-detail-capacity');
    const selectedRoomDetailStatus = document.getElementById('selected-room-detail-status');
    const selectedRoomUnavailableDates = document.getElementById('selected-room-unavailable-dates');

    function parseBookingDate(value) {
        if (!value) return null;
        const raw = value.trim().split(/\s+/)[0];

        const isoMatch = raw.match(/^(\d{4})-(\d{1,2})-(\d{1,2})$/);
        if (isoMatch) {
            return new Date(Number(isoMatch[1]), Number(isoMatch[2]) - 1, Number(isoMatch[3]));
        }

        const slashMatch = raw.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/);
        if (slashMatch) {
            const first = Number(slashMatch[1]);
            const second = Number(slashMatch[2]);
            const year = Number(slashMatch[3]);
            const month = first > 12 ? second : first;
            const day = first > 12 ? first : second;

            return new Date(year, month - 1, day);
        }

        const parsed = new Date(raw);
        return Number.isNaN(parsed.getTime()) ? null : new Date(parsed.getFullYear(), parsed.getMonth(), parsed.getDate());
    }

    function money(value) {
        return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(value || 0);
    }

    function formatDisplayDate(value) {
        const date = parseBookingDate(value);
        if (!date) return value;

        return new Intl.DateTimeFormat('en-US', { month: 'short', day: 'numeric', year: 'numeric' }).format(date);
    }

    function formatDate(date) {
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');

        return `${date.getFullYear()}-${month}-${day}`;
    }

    function todayDate() {
        const now = new Date();
        return new Date(now.getFullYear(), now.getMonth(), now.getDate());
    }

    function addDays(date, days) {
        const nextDate = new Date(date);
        nextDate.setDate(nextDate.getDate() + days);

        return nextDate;
    }

    function syncDateLimits() {
        const today = todayDate();
        const checkIn = parseBookingDate(checkInInput?.value);
        const minCheckout = checkIn ? addDays(checkIn, 1) : addDays(today, 1);

        if (checkInInput) {
            checkInInput.min = formatDate(today);
        }

        if (checkOutInput) {
            checkOutInput.min = formatDate(minCheckout);

            const checkOut = parseBookingDate(checkOutInput.value);
            if (checkOut && checkOut < minCheckout) {
                checkOutInput.value = formatDate(minCheckout);
            }
        }
    }

    function dateValidationMessage() {
        const checkIn = parseBookingDate(checkInInput?.value);
        const checkOut = parseBookingDate(checkOutInput?.value);

        if (!checkIn || !checkOut) {
            return '';
        }

        if (checkIn < todayDate()) {
            return 'Check-in date cannot be in the past.';
        }

        if (checkOut <= checkIn) {
            return 'Check-out date must be after check-in date.';
        }

        return '';
    }

    function selectedDatesOverlap() {
        const roomId = roomSelect?.value;
        const checkIn = parseBookingDate(checkInInput?.value);
        const checkOut = parseBookingDate(checkOutInput?.value);

        if (!roomId || !checkIn || !checkOut || checkOut <= checkIn) {
            return false;
        }

        const requestedCheckIn = formatDate(checkIn);
        const requestedCheckOut = formatDate(checkOut);

        return (roomBookings[roomId] || []).some((booking) => (
            booking.check_in < requestedCheckOut && booking.check_out > requestedCheckIn
        ));
    }

    function roomOverlapsSelectedDates(roomId) {
        const checkIn = parseBookingDate(checkInInput?.value);
        const checkOut = parseBookingDate(checkOutInput?.value);

        if (!roomId || !checkIn || !checkOut || checkOut <= checkIn) {
            return false;
        }

        const requestedCheckIn = formatDate(checkIn);
        const requestedCheckOut = formatDate(checkOut);

        return (roomBookings[roomId] || []).some((booking) => (
            booking.check_in < requestedCheckOut && booking.check_out > requestedCheckIn
        ));
    }

    function updateRoomOptions() {
        if (!roomSelect) return;

        const selectedValue = roomSelect.value;
        let availableCount = 0;

        Array.from(roomSelect.options).forEach((option) => {
            if (!option.value) return;

            const isBooked = roomOverlapsSelectedDates(option.value);
            option.disabled = isBooked;
            option.hidden = isBooked;

            if (!isBooked) {
                availableCount += 1;
            }
        });

        if (selectedValue && roomOverlapsSelectedDates(selectedValue)) {
            roomSelect.value = '';
        }

        const placeholder = roomSelect.options[0];
        if (placeholder) {
            placeholder.textContent = availableCount > 0 ? 'Select A Room' : 'No rooms available for these dates';
        }
    }

    function updateAvailabilityState() {
        updateRoomOptions();

        const dateMessage = dateValidationMessage();
        const hasOverlap = selectedDatesOverlap();
        const selectedInitialUnavailable = initialSelectedRoom && !roomSelect?.value && !initialSelectedRoom.bookable;
        const selectedInitialBookedForDates = initialSelectedRoom
            && !roomSelect?.value
            && initialSelectedRoom.bookable
            && roomOverlapsSelectedDates(initialSelectedRoom.id);
        const noRoomAvailable = roomSelect
            ? Array.from(roomSelect.options).filter((option) => option.value && !option.disabled).length === 0
            : false;
        const message = dateMessage
            || (selectedInitialUnavailable ? `This room is currently ${initialSelectedRoom.status} and cannot be booked now.` : '')
            || (selectedInitialBookedForDates ? 'This room is already booked for the selected dates. Please choose another room or change the dates.' : '')
            || (hasOverlap ? 'This room is already booked for the selected dates. Please choose another room or change the dates.' : '')
            || (noRoomAvailable ? 'No rooms are available for the selected dates. Please change your dates.' : '');

        if (availabilityAlert) {
            availabilityAlert.textContent = message;
            availabilityAlert.classList.toggle('d-none', !message);
        }

        if (bookingSubmit) {
            const shouldDisable = Boolean(message) || !roomSelect?.value;
            bookingSubmit.disabled = shouldDisable;
            bookingSubmit.classList.toggle('disabled', shouldDisable);
            bookingSubmit.textContent = dateMessage
                ? 'Check Dates'
                : (selectedInitialUnavailable || selectedInitialBookedForDates || hasOverlap || noRoomAvailable ? 'Room Unavailable' : 'Continue to Payment');
        }

        return Boolean(message);
    }

    function updateBookingEstimate() {
        syncDateLimits();
        updateRoomOptions();

        const option = roomSelect?.selectedOptions[0];
        const fallbackRoom = !option?.value ? initialSelectedRoom : null;
        const roomId = option?.value || fallbackRoom?.id;
        const price = Number(option?.dataset.price || fallbackRoom?.price || 0);
        const checkIn = parseBookingDate(checkInInput?.value);
        const checkOut = parseBookingDate(checkOutInput?.value);
        const nights = checkIn && checkOut ? Math.max(0, Math.ceil((checkOut - checkIn) / 86400000)) : 0;

        const detailName = option?.dataset.name || fallbackRoom?.name;
        const detailRoom = option?.dataset.room || fallbackRoom?.room;
        const detailImage = option?.dataset.image || fallbackRoom?.image;
        const detailAdults = option?.dataset.adults || fallbackRoom?.adults;
        const detailChildren = option?.dataset.children || fallbackRoom?.children || 0;
        const detailDescription = option?.dataset.description || fallbackRoom?.description;
        const detailStatus = option?.value ? 'available' : fallbackRoom?.status;

        if (roomName) roomName.textContent = detailName ? `${detailName} - Room ${detailRoom}` : 'Select a room';
        if (roomImage && detailImage) roomImage.src = detailImage;
        if (nightsLabel) nightsLabel.textContent = nights;
        if (rateLabel) rateLabel.textContent = money(price);
        if (totalLabel) totalLabel.textContent = money(price * nights);
        if (adultsLabel) adultsLabel.textContent = detailAdults || 'Select room';
        if (childrenLabel) childrenLabel.textContent = detailChildren ?? 'Select room';
        if (adultsInput) adultsInput.value = option?.value ? detailAdults : '';
        if (childrenInput) childrenInput.value = option?.value ? detailChildren : '';
        if (capacityLabel) {
            capacityLabel.textContent = detailAdults
                ? `${detailAdults} adult${Number(detailAdults) === 1 ? '' : 's'}, ${detailChildren || 0} child${Number(detailChildren || 0) === 1 ? '' : 'ren'}`
                : 'Select a room';
        }
        if (selectedRoomDetailImage && detailImage) selectedRoomDetailImage.src = detailImage;
        if (selectedRoomDetailName) selectedRoomDetailName.textContent = detailName ? `${detailName} - Room ${detailRoom}` : 'Choose a room to see details';
        if (selectedRoomDetailDescription) selectedRoomDetailDescription.textContent = detailDescription || 'Select a room from the booking form to view its price, capacity, and unavailable dates.';
        if (selectedRoomDetailRate) selectedRoomDetailRate.textContent = detailName ? money(price) : '-';
        if (selectedRoomDetailCapacity) {
            selectedRoomDetailCapacity.textContent = detailAdults
                ? `${detailAdults} adult${Number(detailAdults) === 1 ? '' : 's'}, ${detailChildren || 0} child${Number(detailChildren || 0) === 1 ? '' : 'ren'}`
                : '-';
        }
        if (selectedRoomDetailStatus) selectedRoomDetailStatus.textContent = detailStatus ? detailStatus.charAt(0).toUpperCase() + detailStatus.slice(1) : '-';
        if (selectedRoomUnavailableDates) {
            const bookings = roomId ? (roomBookings[roomId] || []) : [];
            selectedRoomUnavailableDates.innerHTML = bookings.length
                ? bookings.map((booking) => `<span>${formatDisplayDate(booking.check_in)} - ${formatDisplayDate(booking.check_out)}</span>`).join('')
                : (roomId ? '<span class="available">No booked dates yet</span>' : 'Select a room to view booked dates.');
        }
        updateAvailabilityState();
    }

    [roomSelect, checkInInput, checkOutInput].forEach((element) => {
        element?.addEventListener('change', updateBookingEstimate);
        element?.addEventListener('keyup', updateBookingEstimate);
    });

    bookingForm?.addEventListener('submit', (event) => {
        if (updateAvailabilityState()) {
            event.preventDefault();
            availabilityAlert?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    updateBookingEstimate();
</script>
@endsection
