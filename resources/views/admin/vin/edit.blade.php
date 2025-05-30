@extends('admin/admin-layout')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="heading justify-start">
            <a href="{{ route('vin.index') }}" class="button-indigo" type="button">
                <i class="fa-solid fa-arrow-left fa-lg text-white mr-1"></i> Zpět
            </a>
            <h1 class="heading-title">{$car->model}</h1>
        </div>

        <form method="post" action="{{ route('vin.update', ['vin' => $car->vin]) }}">
            @csrf
            @method('PUT')
            <div class="mb-5">
                <label for="vin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">VIN *</label>
                <input type="text" id="vin" name="vin" value="{{ old('vin', $car->vin) }}" class="form-input" required>
            </div>
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Majitel *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $car->name) }}" class="form-input" required>
            </div>
            <div class="mb-5">
                <label for="manufacturer" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Výrobce</label>
                <input type="text" id="manufacturer" name="manufacturer" value="{{ old('manufacturer', $car->manufacturer) }}" class="form-input">
            </div>
            <div class="mb-5">
                <label for="model" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Model</label>
                <input type="text" id="model" name="model" value="{{ old('model', $car->model) }}" class="form-input">
            </div>
            <div class="mb-5">
                <label for="engine" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Motor</label>
                <input type="text" id="engine" name="engine" value="{{ old('engine', $car->engine) }}" class="form-input">
            </div>
            <div class="mb-5">
                <label for="year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rok výroby</label>
                <input type="text" id="year" name="year" value="{{ old('year', $car->year) }}" class="form-input">
            </div>
            <div class="mb-5">
                <label for="note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Poznámka</label>
                <input type="text" id="note" name="note" value="{{ old('note', $car->note) }}" class="form-input">
            </div>
            <div class="form-buttons">
                <button type="submit" class="form-submit">Odeslat</button>
                <button type="reset" class="form-reset">Vymazat</button>
            </div>
        </form>
    </div>
@endsection
