<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreVehicleRequest extends FormRequest
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
            'manufacturer' => 'required|string',
            'model' => 'required|string',
            'productionYear' => 'required|numeric',
            'vin' => 'required|unique:vehicles|regex:/^[A-HJ-NPR-Za-hj-npr-z\d]{8}[\dX][A-HJ-NPR-Za-hj-npr-z\d]{2}\d{6}$/',
            'spz' => 'required|string|max:7',
            'driver' => 'nullable|string',
            'color' => 'required|string',
            'stk' => 'nullable|date',
            'tachograph' => 'nullable|date',
            'oilChange' => 'nullable|date',
            'insurance' => 'nullable|date',
            'vtp' => 'nullable|file',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Typ je povinný údaj',
            'manufacturer.required' => 'Výrobce je povinný údaj',
            'model.required' => 'Model je povinný údaj',
            'productionYear.required' => 'Rok výroby je povinný údaj',
            'vin.required' => 'VIN je povinný údaj',
            'vin.unique' => 'VIN již existuje',
            'vin.regex' => 'VIN je ve špatném formátu',
            'spz.required' => 'SPZ je povinný údaj',
            'spz.max' => 'SPZ může mít maximálně 7 znaků',
            'color.required' => 'Barva je povinný údaj',
            'stk.required' => 'STK je povinný údaj',
            'stk.date_format' => 'STK je ve špatném formátu',
            'tachograph.date_format' => 'Tachograf je ve špatném formátu',
            'oilChange.date_format' => 'Výměna oleje je ve špatném formátu',
            'insurance.date_format' => 'Pojištění je ve špatném formátu',
        ];
    }

    protected $stopOnFirstFailure = true;

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'errors' => $validator->errors(),
        ], 422);

        throw new ValidationException($validator, $response);
    }
}
