@extends('admin/admin-layout')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="heading justify-start">
            <button onclick="history.back()" class="button-indigo" type="button">
                <i class="fa-solid fa-arrow-left fa-lg icon"></i> Zpět
            </button>
            <h1 class="heading-title">{{ $customer->name }}</h1>
        </div>

        <form method="post" action="{{ route('customers.update', ['customer' => $customer->id]) }}">
            @csrf
            @method('PUT')
            <div class="mb-5">
                <label for="name" class="form-label">Jméno <i class="fa-solid fa-asterisk text-red-600"></i></label>
                <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" class="form-input" required>
            </div>
            <div class="mb-5">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}" class="form-input">
            </div>
            <div class="mb-5">
                <label for="telephone" class="form-label">Telefon</label>
                <input type="text" name="telephone" id="telephone" value="{{ old('telephone', $customer->telephone) }}" class="form-input">
            </div>
            <div class="mb-5">
                <label for="variant" class="form-label">Varianta <i class="fa-solid fa-asterisk text-red-600"></i></label>
                <select name="variant" id="variant" class="form-input" required>
                    <option value="">Vyber...</option>
                    @foreach(App\Enums\CleaningTypes::cases() as $case)
                        <option value="{{ $case->value }}" @if(old('variant', $customer->variant) === $case->value)selected @endif>{{ $case->value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-5">
                <label for="message" class="form-label">Zpráva (slouží i jako poznámka)</label>
                <textarea name="message" id="message" class="form-input" rows="6">{{ old('message', $customer->message) }}</textarea>
            </div>
            <div class="mb-5">
                <label for="date" class="form-label">Datum</label>
                <input type="date" name="term" id="date" value="{{ old('term', empty($customer->term) ? null : \Illuminate\Support\Carbon::parse($customer->term)->toDateString()) }}" class="form-input">
            </div>
            <div class="form-buttons">
                <button type="submit" class="form-submit">Odeslat</button>
                <button type="reset" class="form-reset">Vymazat</button>
            </div>
        </form>
    </div>
@endsection
