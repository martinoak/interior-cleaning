@extends('admin/admin-layout')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="heading justify-start">
            <button onclick="history.back()" class="button-indigo" type="button">
                <i class="fa-solid fa-arrow-left fa-lg icon"></i> Zpět
            </button>
            <h1 class="heading-title">{{ $voucher['message'] }}</h1>
        </div>
        <div class="grid grid-cols-1 gap-4 mb-4">
            <div class="cell">
                <div class="cell-content justify-between">
                    <h2 class="cell-title">{{ $voucher['hash'] }}</h2>
                    <div class="flex justify-center gap-4 mr-2">
                        @if($voucher['status'] == 'green')
                            <a href="{{ route('vouchers.use', ['hash' => $voucher['hash']]) }}" class="button-green">Uplatnit</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div class="cell-simple">
                <i class="fa-solid fa-hashtag icon"></i>{{ $voucher['hash'] }}
            </div>
            <div class="cell-simple">
                <i class="fa-solid fa-dollar-sign icon"></i>{{ $voucher['price'] }},-
            </div>
            <div class="cell-simple">
                <i class="hidden sm:block fa-regular fa-clock icon"></i>{{ date('j.n.Y', $voucher['dateFrom'] }} - {{ date('j.n.Y', $voucher['dateTo'] }}
            </div>
        </div>
    </div>
@endsection
