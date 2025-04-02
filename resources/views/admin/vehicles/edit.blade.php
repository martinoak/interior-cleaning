@extends('admin/admin-layout')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="heading justify-start">
            <button onclick="history.back()" class="button-indigo" type="button">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </button>
            <h1 class="heading-title">{{ $vehicle->manufacturer }} {{ $vehicle->model }}</h1>
        </div>

        <form method="post" action="{{ route('vehicles.update', ['vehicle' => $vehicle->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="api-token" value="{{ auth()->user()->api_token }}">

            <div class="mb-5">
                <label for="manufacturer" class="form-label">Výrobce <i class="fa-solid fa-asterisk text-red-600"></i></label>
                <input type="text" name="manufacturer" id="manufacturer" value="{{ old('manufacturer', $vehicle->manufacturer) }}" class="form-input" required>
            </div>

            <div class="mb-5">
                <label for="model" class="form-label">Model <i class="fa-solid fa-asterisk text-red-600"></i></label>
                <input type="text" name="model" id="model" value="{{ old('model', $vehicle->model) }}" class="form-input" required>
            </div>

            <div class="mb-5">
                <label for="productionYear" class="form-label">Rok výroby <i class="fa-solid fa-asterisk text-red-600"></i></label>
                <input type="number" name="productionYear" id="productionYear" class="form-input" inputmode="numeric" pattern="[0-9]*" value="{{ old('productionYear', $vehicle->productionYear) }}" required>
            </div>

            <div class="mb-5">
                <label for="spz" class="form-label">SPZ <i class="fa-solid fa-asterisk text-red-600"></i></label>
                <input type="text" name="spz" id="spz" value="{{ old('spz', $vehicle->spz) }}" class="form-input" required>
            </div>

            <div class="mb-5">
                <label for="vin" class="form-label">VIN</label>
                <input type="text" name="vin" id="vin" value="{{ old('vin', $vehicle->vin) }}" class="form-input">
            </div>

            <div class="mb-5">
                <label for="color" class="form-label">Barva <i class="fa-solid fa-asterisk text-red-600"></i></label>
                <input type="color" name="color" id="color" value="{{ old('color', $vehicle->color) }}" class="form-input" style="min-height: 50px" required>
            </div>

            <div class="mb-5">
                <label for="color" class="form-label">Typ <i class="fa-solid fa-asterisk text-red-600"></i></label>
                <ul class="grid w-full gap-6 grid-cols-3 mt-2">
                    @foreach(\App\Enums\VehicleType::cases() as $type)
                        <li>
                            <input type="radio" id="{{ $type->value }}" name="type" value="{{ $type->value }}" class="hidden peer" @if(old('type', $vehicle->type) === $type->value)checked @endif required />
                            <label for="{{ $type->value }}" class="vehicle-type">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                        <i class="{{ \App\Enums\VehicleType::getIcon($type->value) }} fa-lg mr-2"></i> {{ $type->getName() }}
                                    </div>
                                </div>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mb-5">
                <label for="vtp" class="form-label">VTP</label>
                <input type="file" name="vtp" id="vtp" class="file-input">
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Není potřeba nahrávat VTP, pokud v něm nedošlo ke změně.</p>
            </div>

            <div class="mb-5">
                <label for="stk" class="form-label">STK</label>
                <input type="date" name="stk" id="stk" value="{{ old('stk', $vehicle->stk ? date_format($vehicle->stk, 'Y-m-d') : '') }}" class="form-input">
            </div>

            <div class="mb-5">
                <label for="oilChange" class="form-label">Výměna oleje</label>
                <input type="date" name="oilChange" id="oilChange" value="{{ old('oilChange', $vehicle->oilChange ? date_format($vehicle->oilChange, 'Y-m-d') : '') }}" class="form-input">
            </div>

            <div class="mb-5">
                <label for="insurance" class="form-label">Povinné ručení</label>
                <input type="date" name="insurance" id="insurance" value="{{ old('insurance', $vehicle->insurance ? date_format($vehicle->insurance, 'Y-m-d') : '') }}" class="form-input">
            </div>

            <div class="mb-5">
                <label for="tachograph" class="form-label">Tachograf</label>
                <input type="date" name="tachograph" id="tachograph" value="{{ old('tachograph', $vehicle->tachograph ? date_format($vehicle->tachograph, 'Y-m-d') : '') }}" class="form-input">
            </div>

            <div class="mb-5">
                <label for="spneu" class="form-label">Letní pneu (rok)</label>
                <input type="number" name="spneu" id="spneu" class="form-input" inputmode="numeric" pattern="[0-9]*" value="{{ old('productionYear', $vehicle->spneu) }}">
            </div>

            <div class="mb-5">
                <label for="wpneu" class="form-label">Zimní pneu (rok)</label>
                <input type="number" name="wpneu" id="wpneu" class="form-input" inputmode="numeric" pattern="[0-9]*" value="{{ old('productionYear', $vehicle->wpneu) }}">
            </div>

            <button type="submit" class="button-blue mt-6 w-full">Aktualizovat vozidlo</button>
        </form>
    </div>
@endsection
