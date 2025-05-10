<?php

namespace App\Http\Requests\Availability;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Foundation\Http\FormRequest;

class RoomBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Booking fields:
            'room_id' => 'required|exists:rooms,room_id',
            'guest_name' => 'required|string|max:100',
            'guest_phone' => 'required|string|max:15',
            'guest_email' => 'nullable|email|max:100',
            'guest_address' => 'nullable|string|max:255',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'extra_pax' => 'nullable|integer|min:0',
            'special_requests' => 'nullable|string|max:255',

            // Payment fields:
            'total_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
            'reference_number' => 'nullable|string|max:100',
            'amount_paid' => 'nullable|numeric|min:0',
            'change' => 'nullable|numeric|min:0',
            'payment_notes' => 'nullable|string|max:255',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $roomId = $this->input('room_id');
            $checkIn = $this->input('check_in_date');
            $checkOut = $this->input('check_out_date');

            $room = Room::where('room_id', $roomId)->first();
            if ($room && $room->status === 'maintenance') {
                $validator->errors()->add('room_id', 'This room is under maintenance and cannot be booked.');
            }

            if ($roomId && $checkIn && $checkOut) {
                $overlap = Booking::where('room_id', $roomId)
                    ->where(function ($query) use ($checkIn, $checkOut) {
                        $query->where('check_in_date', '<', $checkOut)
                            ->where('check_out_date', '>', $checkIn);
                    })
                    ->exists();

                if ($overlap) {
                    $validator->errors()->add('check_in_date', 'This room is already booked for the selected dates.');
                }
            }
        });
    }
}
