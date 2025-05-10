<?php

namespace App\Http\Controllers\Availability;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;

class VenueAvailabilityController extends Controller
{
    public function venue($venue)
    {
        $venue = Venue::with(['category', 'venueGallery'])
            ->where('venue_id', $venue)
            ->firstOrFail();
        return view('availability.venue', compact('venue'));
    }
}
