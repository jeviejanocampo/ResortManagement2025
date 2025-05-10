<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
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
        $roomId = $this->route('room') ? $this->route('room')->room_id : null;

        return [
            'room_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rooms', 'room_number')->ignore($roomId, 'room_id'),
            ],
            'room_type' => 'required|string|max:50',
            'option_category_id' => 'required|exists:option_categories,option_category_id',
            'pax' => 'required|integer|min:1',
            'rate_per_night' => 'required|numeric|min:0',
            'rate_per_pax' => 'required|numeric|min:0',
            'checked_in' => 'nullable|date_format:H:i',
            'checked_out' => 'nullable|date_format:H:i',
            'status' => 'required|string|in:available,maintenance',
            'description' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}