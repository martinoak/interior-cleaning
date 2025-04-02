@extends('admin/admin-layout')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="heading justify-start">
            <button onclick="history.back()" class="button-indigo" type="button">
                <i class="fa-solid fa-arrow-left fa-lg icon"></i> Zpět
            </button>
            <h1 class="heading-title">Nová faktura</h1>
        </div>

        <form method="post" action="{{ route('invoices.store') }}">
            @csrf
            <div class="mb-5">
                <label for="name" class="form-label">Název faktury <i class="fa-solid fa-asterisk text-red-600"></i></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-input" required>
            </div>
            <div class="mb-5">
                <label for="type" class="form-label">Typ faktury <i class="fa-solid fa-asterisk text-red-600"></i></label>
                <select name="type" id="type" class="form-input" required>
                    @foreach(App\Enums\InvoiceTypes::cases() as $case)
                        <option value="{{ $case->value }}" @if(old('variant') === $case->value)selected @endif>
                            {{ $case->getReadableFormat() }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-5">
                <label for="price" class="form-label">Částka <i class="fa-solid fa-asterisk text-red-600"></i></label>
                <input name="price" id="price" class="form-input" type="number" inputmode="numeric" pattern="[0-9]*" value="{{ old('price') }}" required>
            </div>
            <div class="mb-5">
                <label for="date" class="form-label">Datum <i class="fa-solid fa-asterisk text-red-600"></i></label>
                <input type="date" name="date" id="date" value="{{ old('term', \Illuminate\Support\Carbon::parse(time())->toDateString()) }}" class="form-input" required>
            </div>
            <input type="hidden" name="worker" value="S">
            <div class="form-buttons">
                <button type="submit" class="form-submit">Odeslat</button>
                <button type="reset" class="form-reset">Vymazat</button>
            </div>
        </form>
    </div>
@endsection
