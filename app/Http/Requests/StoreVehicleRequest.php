<?php

namespace App\Http\Requests;

use App\Enums\VehicleType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'manufacturer' => 'required|string',
            'model' => 'required|string',
            'productionYear' => 'required|numeric',
            'vin' => 'unique:vehicles',
            'spz' => 'required|string|max:7',
            'driver' => 'nullable|string',
            'color' => 'required|string',
            'type' => ['required', Rule::in(VehicleType::toArray())],
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
            'type.in' => 'Typ může být pouze osobní nebo nákladní',
            'manufacturer.required' => 'Výrobce je povinný údaj',
            'model.required' => 'Model je povinný údaj',
            'productionYear.required' => 'Rok výroby je povinný údaj',
            'vin.unique' => 'VIN již existuje',
            'spz.required' => 'SPZ je povinný údaj',
            'spz.max' => 'SPZ může mít maximálně 7 znaků',
            'color.required' => 'Barva je povinný údaj',
            'stk.required' => 'STK je povinný údaj',
            'stk.date' => 'STK je ve špatném formátu',
            'tachograph.date' => 'Tachograf je ve špatném formátu',
            'oilChange.date' => 'Výměna oleje je ve špatném formátu',
            'insurance.date' => 'Pojištění je ve špatném formátu',
        ];
    }
}
