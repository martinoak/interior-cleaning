<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'login' => 'required',
            'role' => 'required|in:'.implode(',', \App\Enums\Role::toArray()),
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Jméno je povinný údaj',
            'login.required' => 'Login je povinný údaj',
            'role.required' => 'Role je povinný údaj',
            'role.in' => 'Neplatná role',
        ];
    }
}
