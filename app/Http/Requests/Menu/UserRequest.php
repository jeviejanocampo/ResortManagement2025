<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $userId = $this->route('user') ? $this->route('user')->id : null;
        $isSuperuser = Auth::user() && Auth::user()->is_superuser;

        $rules = [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other,prefer_not_to_say',
            'phone_number' => 'nullable|string|max:20',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId),
            ],
            'is_staff' => 'boolean',
        ];

        if ($isSuperuser) {
            $rules['is_superuser'] = 'boolean';
            $rules['is_owner'] = 'boolean';
        }

        return $rules;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'is_superuser' => $this->boolean('is_superuser'),
            'is_owner' => $this->boolean('is_owner'),
            'is_staff' => $this->boolean('is_staff'),
        ]);
    }
}
