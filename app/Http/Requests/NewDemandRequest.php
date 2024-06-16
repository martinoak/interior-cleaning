<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewDemandRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email',
            'telephone' => 'required|string|min:9',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Jméno je povinné pole',
            'email.required' => 'Email je povinné pole',
            'email.email' => 'Email musí být ve správném formátu',
            'telephone.required' => 'Telefon je povinné pole',
            'telephone.min' => 'Telefon musí mít alespoň 9 znaků',
        ];
    }

    public function getRedirectUrl(): string
    {
        return parent::getRedirectUrl().'#kontakt';
    }
}
