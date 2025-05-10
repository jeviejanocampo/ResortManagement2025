<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\RoomRequest;
use App\Models\Room;
use App\Models\OptionCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with(['category', 'roomGallery'])->latest()->get();
        $categories = OptionCategory::where('status', 'active')->get();

        return view('menu.rooms', compact('rooms', 'categories'));
    }

    public function store(RoomRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $room = Room::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('room_images', 'public');
                $room->roomGallery()->create(['image_name' => $path]);
            }
        }

        return redirect()->route('rooms')->with('success', 'Room created successfully.');
    }

    public function update(RoomRequest $request, Room $room)
    {
        $data = $request->validated();

        $room->update($data);

        if ($request->hasFile('images')) {
            foreach ($room->roomGallery as $image) {
                Storage::disk('public')->delete($image->image_name);
                $image->delete();
            }

            foreach ($request->file('images') as $image) {
                $path = $image->store('room_images', 'public');
                $room->roomGallery()->create(['image_name' => $path]);
            }
        }

        return redirect()->route('rooms')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        foreach ($room->roomGallery as $image) {
            Storage::disk('public')->delete($image->image_name);
        }

        $room->delete();

        return redirect()->route('rooms')->with('success', 'Room deleted successfully.');
    }
}