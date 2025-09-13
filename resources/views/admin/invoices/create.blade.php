@extends('admin/layout')

@section('content')
    <h1 class="heading-title">Nová faktura</h1>

    <form method="post" action="{{ route('invoices.store') }}">
        @csrf

        <div class="form-wrapper">
            <div class="form-row">
                <label for="name">Název faktury *</label>
                <div class="mt-2 sm:col-span-2 sm:mt-0">
                    <input id="name" type="text" name="name" autocomplete="off" class="max-w-xs" value="{{ old('name') }}" required />
                </div>
            </div>

            <div class="form-row">
                <label for="price">Částka *</label>
                <div class="mt-2 sm:col-span-2 sm:mt-0">
                    <input id="price" type="number" name="price" autocomplete="off" class="max-w-xs" value="{{ old('price') }}" required />
                </div>
            </div>

            <div class="form-row">
                <label for="price">Typ *</label>
                <div class="mt-2 sm:col-span-2 sm:mt-0">
                    <select id="type" name="type" class="max-w-xs" required>
                        @foreach(App\Enums\InvoiceTypes::cases() as $case)
                            <option value="{{ $case->value }}" @if(old('variant') === $case->value)selected @endif>
                                {{ $case->getReadableFormat() }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <label for="date">Datum faktury *</label>
                <div class="mt-2 sm:col-span-2 sm:mt-0">
                    <input id="date" type="date" name="date" autocomplete="off" class="max-w-xs" value="{{ old('date', \Illuminate\Support\Carbon::parse(time())->toDateString()) }}" required />
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm/6 font-semibold text-gray-900 dark:text-white">Zrušit</button>
            <button type="submit" class="primary w-1/6 h-12">Vytvořit fakturu</button>
        </div>
    </form>
@endsection
