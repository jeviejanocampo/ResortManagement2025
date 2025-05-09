<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;

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
