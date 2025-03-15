<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceLogRequest extends FormRequest
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
            'title' => 'required',
            'service_date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Název opravy je povinný.',
            'service_date.required' => 'Datum opravy je povinné.',
            'service_date.date' => 'Datum servisu je ve špatném formátu.',
        ];
    }
}
