<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OptionCategory;
use App\Models\Room;
use App\Models\RoomGallery;

class RoomController extends Controller

{

    public function fetchRooms()
    {
        $categories = OptionCategory::where('status', 'active')->get();
        return response()->json($categories);
    }

    public function fetchRoomsByCategory(Request $request)
    {
        $categoryId = $request->query('option_category_id');
    
        if (!$categoryId) {
            return response()->json(['error' => 'option_category_id is required'], 400);
        }
    
        $rooms = Room::where('option_category_id', $categoryId)->get();
    
        return response()->json($rooms);
    }

    public function fetchRoomGallery(Request $request)
    {
        $roomId = $request->query('room_id');

        if (!$roomId) {
            return response()->json(['error' => 'room_id is required'], 400);
        }

        $images = RoomGallery::where('room_id', $roomId)->get(['image_name']);

        return response()->json($images);
    }

    
}
