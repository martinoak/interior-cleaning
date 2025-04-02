@extends('admin/admin-layout')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="heading justify-start">
            <button onclick="history.back()" class="button-indigo" type="button">
                <i class="fa-solid fa-arrow-left fa-lg text-white mr-1"></i> Zpět
            </button>
            <h1 class="heading-title">Faktura</h1>
        </div>

        <form method="post" action="{{ route('invoices.update', ['invoice' => $invoice->id]) }}">
            @csrf
                @method('PUT')
            <div class="mb-5">
                <label for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID faktury</label>
                <input type="text" id="id" name="id" value="{{ old('id', $invoice->id) }}" class="form-input" readonly>
            </div>
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Zákazník</label>
                <input type="text" id="name" name="name" value="{{ old('name', $invoice->name) }}" class="form-input" required>
            </div>
            <div class="mb-5">
                <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Typ faktury</label>
                <select id="type" name="type" class="form-input">
                    <option value="T" @if($invoice->type === 'T')selected @endif class="text-green-600">Tržba</option>
                    <option value="N" @if($invoice->type === 'N')selected @endif class="text-red-600">Náklad</option>
                    <option value="P" @if($invoice->type === 'P')selected @endif class="text-blue-600">Poukaz</option>
                </select>
            </div>
            <div class="mb-5">
                <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Datum</label>
                <input type="text" id="date" name="date" value="{{ old('date', $invoice->date) }}" class="form-input">
            </div>
            <div class="mb-5">
                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cena</label>
                <input type="text" id="price" name="price" value="{{ old('price', $invoice->price) }}" class="form-input">
            </div>
            <div class="form-buttons">
                <button type="submit" class="form-submit">Odeslat</button>
                <button type="reset" class="form-reset">Vymazat</button>
            </div>
        </form>
    </div>
@endsection
