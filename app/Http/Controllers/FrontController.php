<?php

namespace App\Http\Controllers;

use App\Models\AboutFeature;
use App\Models\BookingPageImage;
use App\Models\ServiceItem;
use App\Models\ServicePage;
use App\Models\AboutGalleryImage;
use App\Models\AboutPage;
use App\Models\HeroSlide;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class FrontController extends Controller
{
    public function home(): View
    {
        return view('front.home', [
            'rooms' => Room::with('roomType')->where('status', 'available')->latest('id')->limit(6)->get(),
            'testimonials' => Testimonial::where('is_approved', true)->with('user')->latest('id')->limit(8)->get(),
            'heroSlides' => HeroSlide::activeOrdered()->get(),
        ]);
    }

    public function about(): View
    {
        $aboutPage = AboutPage::current();

        return view('front.about', [
            'aboutPage' => $aboutPage->is_active ? $aboutPage : null,
            'aboutFeatures' => AboutFeature::activeOrdered()->get(),
            'aboutGalleryImages' => AboutGalleryImage::activeOrdered()->get(),
        ]);
    }

    public function service(): View
    {
        $servicePage = ServicePage::current();

        return view('front.service', [
            'servicePage' => $servicePage->is_active ? $servicePage : null,
            'serviceItems' => ServiceItem::activeOrdered()->get(),
        ]);
    }

    public function rooms(Request $request): View
    {
        $rooms = Room::with('roomType')->where('status', 'available');

        if ($request->filled(['check_in', 'check_out'])) {
            $checkIn = Carbon::parse($request->check_in)->toDateString();
            $checkOut = Carbon::parse($request->check_out)->toDateString();

            $rooms->whereDoesntHave('bookings', function ($query) use ($checkIn, $checkOut): void {
                $query->blockingAvailability()
                    ->where('check_in', '<', $checkOut)
                    ->where('check_out', '>', $checkIn);
            });
        }

        return view('front.rooms', [
            'rooms' => $rooms->latest('id')->paginate(6)->withQueryString(),
        ]);
    }

    public function roomDetails(Room $room): View
    {
        $room->load('roomType');

        abort_if($room->status !== 'available', 404);

        return view('front.room-details', [
            'room' => $room,
        ]);
    }

    public function booking(Request $request): View
    {
        $selectedRoom = null;
        if ($request->filled('room_id')) {
            $selectedRoom = Room::with([
                'roomType',
                'bookings' => fn ($query) => $query
                    ->blockingAvailability()
                    ->select('id', 'room_id', 'check_in', 'check_out', 'status'),
            ])->find($request->room_id);
        }

        $rooms = Room::with([
            'roomType',
            'bookings' => fn ($query) => $query
                ->blockingAvailability()
                ->select('id', 'room_id', 'check_in', 'check_out', 'status'),
        ])->where('status', 'available');

        $rooms = $rooms->get();
        $roomBookingSource = $selectedRoom
            ? $rooms->concat([$selectedRoom])->unique('id')
            : $rooms;

        return view('front.booking', [
            'rooms' => $rooms,
            'selectedRoom' => $selectedRoom,
            'bookingPageImages' => BookingPageImage::activeOrdered()->get(),
            'roomBookings' => $roomBookingSource->mapWithKeys(fn ($room) => [
                $room->id => $room->bookings->map(fn ($booking) => [
                    'check_in' => optional($booking->check_in)->format('Y-m-d'),
                    'check_out' => optional($booking->check_out)->format('Y-m-d'),
                    'status' => $booking->status,
                ])->values(),
            ]),
        ]);
    }

    public function team(): View
    {
        return view('front.team', [
            'team' => User::whereIn('role', ['receptionist', 'manager', 'admin', 'staff'])->get(),
        ]);
    }

    public function testimonial(): View
    {
        return view('front.testimonial', [
            'testimonials' => Testimonial::where('is_approved', true)->with('user')->latest('id')->limit(20)->get(),
        ]);
    }
}
