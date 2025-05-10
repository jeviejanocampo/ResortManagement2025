<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class VenueRequest extends FormRequest
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
            'option_category_id' => 'required|exists:option_categories,option_category_id',
            'name' => 'required|string|max:255',
            'check_in_time' => 'nullable|date_format:H:i',
            'check_out_time' => 'nullable|date_format:H:i',
            'visitor_time_limit' => 'nullable|date_format:H:i',
            'additional_overnight_price_per_pax' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|string|in:available,maintenance',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tiers' => 'nullable|array',
            'tiers.*.max_pax' => 'required_with:tiers|integer|min:1',
            'tiers.*.price' => 'required_with:tiers|numeric|min:0',
            'tiers.*.included_overnight_pax' => 'nullable|integer|min:0',
        ];
    }
}
