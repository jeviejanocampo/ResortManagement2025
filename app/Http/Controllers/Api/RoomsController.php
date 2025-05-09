<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
    public function fetchRoomsByCategory(Request $request)
    {
        $categoryId = $request->query('option_category_id');
    
        if (!$categoryId) {
            return response()->json(['error' => 'option_category_id is required'], 400);
        }
    
        $rooms = Room::where('option_category_id', $categoryId)->get();
    
        return response()->json($rooms);
    }
}
