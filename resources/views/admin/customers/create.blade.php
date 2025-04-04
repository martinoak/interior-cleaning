@extends('admin/admin-layout')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="heading justify-start">
            <a href="{{ route('customers.index') }}" class="button-indigo" type="button">
                <i class="fa-solid fa-arrow-left fa-lg icon"></i> Zpět
            </a>
            <h1 class="heading-title">Nový zákazník</h1>
        </div>

        <form method="post" action="{{ route('customers.store') }}">
            @csrf
            <div class="mb-5">
                <label for="name" class="form-label">Jméno <i class="fa-solid fa-asterisk text-red-600"></i></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-input" required>
            </div>
            <div class="mb-5">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-input">
            </div>
            <div class="mb-5">
                <label for="telephone" class="form-label">Telefon</label>
                <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}" class="form-input">
            </div>
            <div class="mb-5">
                <label for="variant" class="form-label">Varianta <i class="fa-solid fa-asterisk text-red-600"></i></label>
                <select name="variant" id="variant" class="form-input" required>
                    @foreach(App\Enums\CleaningTypes::cases() as $case)
                        <option value="{{ $case->value }}" @if(old('variant') === $case->value)selected @endif>{{ $case->value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-5">
                <label for="message" class="form-label">Zpráva</label>
                <textarea name="message" id="message" class="form-input" rows="2"></textarea>
            </div>
            <div class="mb-5">
                <label for="date" class="form-label">Datum</label>
                <input type="date" name="term" id="date" class="form-input">
            </div>
            <div class="form-buttons">
                <button type="submit" class="form-submit">Odeslat</button>
                <button type="reset" class="form-reset">Vymazat</button>
            </div>
        </form>
    </div>
@endsection
