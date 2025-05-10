<?php

namespace App\Http\Controllers\Availability;

use App\Http\Controllers\Controller;
use App\Http\Requests\Availability\RoomBookingRequest;
use App\Models\Booking;
use App\Models\Room;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class RoomAvailabilityController extends Controller
{
    public function room($room)
    {
        $room = Room::with(['category', 'roomGallery'])
            ->where('room_id', $room)
            ->firstOrFail();
        return view('availability.room', compact('room'));
    }

    public function roomBooking(RoomBookingRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
    
        $paymentFields = [
            'total_amount',
            'payment_method',
            'reference_number',
            'amount_paid',
            'change',
            'payment_notes',
        ];
        $paymentData = [];
        foreach ($paymentFields as $field) {
            $paymentData[$field] = $data[$field] ?? null;
            unset($data[$field]);
        }
    
        $booking = Booking::create($data);
        $booking->payment()->create($paymentData);
    
        $booking->load(['room', 'payment']);
        $pdf = Pdf::loadView('pdf.booking', compact('booking'));
    
        return $pdf->stream('official-receipt.pdf');
    }

    public function getRoomEvents($room)
    {
        $bookings = Booking::where('room_id', $room)->get();

        $events = $bookings->map(function ($booking) {
            return [
                'title' => "Booked by: {$booking->guest_name}",
                'start' => $booking->check_in_date,
                'end' => $booking->check_out_date,
                'className' => 'event-primary border-primary'
            ];
        });

        return response()->json($events);
    }
}
