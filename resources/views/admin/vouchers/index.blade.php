@extends('admin/layout')

@section('content')
    <h1 class="heading-title">Vouchery</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
        <div class="cell">
            <div class="cell-content">
                <h2 class="cell-title">Aktivní</h2>
            </div>
            <p class="cell-note items-center text-md font-bold">
                @foreach($vouchers as $voucher)
                    @if(! str_starts_with($voucher->hash, 'x'))
                        <a class="px-1 hover:text-primary" href="{{ route('vouchers.show', ['voucher' => $voucher->hash]) }}">{{ $voucher->hash }}</a>
                    @endif
                @endforeach
            </p>
        </div>
        <div class="cell">
            <div class="cell-content">
                <h2 class="cell-title">10% slevy</h2>
            </div>
            <p class="cell-note items-center text-md">
                @foreach($vouchers as $voucher)
                    @if(str_starts_with($voucher->hash, 'x'))
                        <span class="px-1 @if(session('voucher') === $voucher->hash)text-indigo-600 font-bold @endif">{{ $voucher->hash }}</span>
                    @endif
                @endforeach
            </p>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
        <div class="cell">
            <div class="cell-content justify-between">
                <h2 class="cell-title">Založit</h2>
                <form class="cell-text hidden sm:flex space-x-2 text-lg" method="post" action="{{ route('vouchers.store', ['type' => 'regular']) }}">
                    @csrf
                    @foreach(App\Enums\CleaningTypes::cases() as $case)
                        <button type="submit" name="variant" value="{{ $case->value }}" class="primary">
                            <i class="fa-solid fa-{{ $loop->iteration }} mr-2"></i> {{ $case->value }}
                        </button>
                    @endforeach
                </form>
            </div>
            <div class="cell-note-mobile">
                <form class="cell-text flex space-x-2 text-lg" method="post" action="{{ route('vouchers.store', ['type' => 'regular']) }}">
                    @csrf
                    @foreach(App\Enums\CleaningTypes::cases() as $case)
                        <button type="submit" name="variant" value="{{ $case->value }}" style="@if($loop->first)margin-left: 0 !important;@endif" class="w-1/3 button-yellow">
                            {{ $case->getShortenedTitle() }}
                        </button>
                    @endforeach
                </form>
            </div>
        </div>
        <div class="cell">
            <div class="cell-content justify-between">
                <h2 class="cell-title">10% sleva</h2>
                <form class="cell-text space-x-2 text-lg" method="post" action="{{ route('vouchers.store', ['type' => 'mini']) }}">
                    @csrf
                    <button type="submit" class="green">
                        <i class="fa-solid fa-percent mr-2"></i> Generovat
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4 mb-4">
        <div class="cell">
            <div class="cell-content">
                <h2 class="cell-title">Verifikace</h2>
            </div>
            <div class="cell-note">
                <form action="{{ route('vouchers.validate') }}" method="post">
                    @csrf
                    <div class="space-y-6">
                        <div class="flex flex-col">
                            <label for="hash" class="form-label">Kód voucheru <i class="fa-solid fa-asterisk text-red-600"></i></label>
                            <input type="text" name="hash" id="hash" required>
                        </div>
                        <button type="submit" class="red">Ověřit voucher</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
