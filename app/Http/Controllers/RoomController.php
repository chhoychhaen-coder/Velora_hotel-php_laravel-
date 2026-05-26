<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function index(): View
    {
        return view('admin.rooms.index', [
            'rooms' => Room::with('roomType')->latest('id')->paginate(10),
            'roomTypes' => RoomType::where('is_active', true)->orderBy('name')->get(),
        ]);
    }
    public function create(): View
    {
        return view('admin.rooms.create', [
            'roomTypes' => RoomType::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function edit(Room $room): View
    {
        return view('admin.rooms.edit', [
            'room' => $room,
            'roomTypes' => RoomType::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Room::create($request->validate([
            'room_type_id' => ['required', 'exists:room_types,id'],
            'room_number' => ['required', 'string', 'max:10', 'unique:rooms,room_number'],
            'floor' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['available', 'occupied', 'maintenance'])],
            'notes' => ['nullable', 'string'],
        ]));

         return redirect()
        ->route('admin.rooms.index')
        ->with('success', 'Room created successfully.');
    }

    public function update(Request $request, Room $room): RedirectResponse
    {
        $room->update($request->validate([
            'room_type_id' => ['required', 'exists:room_types,id'],
            'room_number' => ['required', 'string', 'max:10', Rule::unique('rooms', 'room_number')->ignore($room)],
            'floor' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['available', 'occupied', 'maintenance'])],
            'notes' => ['nullable', 'string'],
        ]));

return redirect()
    ->route('admin.rooms.index')
    ->with('success', 'Room updated successfully.');    }

    public function destroy(Room $room): RedirectResponse
    {
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }
}
