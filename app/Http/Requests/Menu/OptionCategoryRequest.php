<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OptionCategoryRequest extends FormRequest
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
        $categoryId = $this->route('category') ? $this->route('category')->option_category_id : null;
    
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('option_categories', 'name')->ignore($categoryId, 'option_category_id')
            ],
            'status' => 'required|string|in:active,inactive',
        ];
    }
}
