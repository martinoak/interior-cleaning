@extends('admin/admin-layout')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="heading justify-between">
            <a href="{{ route('vehicles.index') }}" class="button-indigo" type="button">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </a>
            <h1 class="heading-title">{{ $vehicle->manufacturer }} {{ $vehicle->model }}</h1>
            <aside class="flex gap-4">
                <a href="{{ route('service-book.index', ['vehicle' => $vehicle->id]) }}" class="button-black"><i class="fa-solid fa-wrench fa-lg"></i></a>
            </aside>
        </div>
        <dl class="w-full text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
            <div class="flex flex-col py-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Výrobce</dt>
                <dd class="text-lg font-semibold">{{ $vehicle->manufacturer }}</dd>
            </div>
            <div class="flex flex-col py-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Model</dt>
                <dd class="text-lg font-semibold">{{ $vehicle->model }}</dd>
            </div>
            <div class="flex flex-col py-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Rok výroby</dt>
                <dd class="text-lg font-semibold">{{ $vehicle->productionYear }}</dd>
            </div>
            <div class="flex flex-col py-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">VIN</dt>
                <dd class="text-lg font-semibold flex items-center">
                    @if($vehicle->vin)
                        {{ $vehicle->vin }}
                        <button type="button" class="ml-2 button-indigo px-3 py-2" onclick="navigator.clipboard.writeText('{{ $vehicle->vin }}')">
                            <i class="fa-regular fa-paste"></i>
                        </button>
                    @else
                        <em class="text-gray-400">--- Nevyplněno ---</em>
                    @endif
                </dd>
            </div>
            <div class="flex flex-col py-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">SPZ</dt>
                <dd class="text-lg font-semibold">{{ $vehicle->spz }}</dd>
            </div>
            <div class="flex flex-col py-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">VTP</dt>
                <dd class="text-lg font-semibold">
                    @if($vehicle->vtp)
                        <a href="{{ $vehicle->vtp }}" target="_blank" class="button-black w-full">Zobrazit VTP</a>
                    @else
                        <em class="text-gray-400">--- Nenahráno ---</em>
                    @endif
                </dd>
            </div>
            <div class="flex flex-col py-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Řidič</dt>
                <dd class="text-lg font-semibold">{{ $vehicle->driver ?? '-' }}</dd>
            </div>
            <div class="flex flex-col py-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Barva</dt>
                <dd class="text-lg font-semibold">
                    <div class="w-full h-8 rounded-lg" style="background-color: {!! $vehicle->color !!}"></div>
                </dd>
            </div>
            <div class="flex flex-col py-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">STK</dt>
                <dd class="text-lg font-semibold">
                    @if(empty($vehicle->stk))
                        <em class="text-gray-400">--- Nevyplněno ---</em>
                    @elseif(Carbon\Carbon::parse($vehicle->stk) < now())
                        <span class="font-bold text-red-500">
                            Po datu! <span class="text-gray dark:text-gray-400">({{ Carbon\Carbon::parse($vehicle->stk)->format('j.n.Y') }})</span>
                        </span>
                    @else
                        {{ Carbon\Carbon::parse($vehicle->stk)->format('j.n.Y') }}
                        @php $diff = Carbon\Carbon::parse($vehicle->stk)->diffInDays(now()->addDays(-1), true) @endphp
                        <span class="@if($diff < 30)text-orange-500 @else text-gray-500 dark:text-gray-400 @endif">
                            (za {{ floor(Carbon\Carbon::parse($vehicle->stk)->diffInDays(now()->addDays(-1), true)) }} dní)
                        </span>
                    @endif
                </dd>
            </div>
            <div class="flex flex-col py-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Výměna oleje</dt>
                <dd class="text-lg font-semibold">
                    @if(empty($vehicle->oilChange))
                        <em class="text-gray-400">--- Nevyplněno ---</em>
                    @elseif(Carbon\Carbon::parse($vehicle->oilChange) < now())
                        <span class="font-bold text-red-500">
                            Po datu! <span class="text-gray dark:text-gray-400">({{ Carbon\Carbon::parse($vehicle->oilChange)->format('j.n.Y') }})</span>
                        </span>
                    @else
                        {{ Carbon\Carbon::parse($vehicle->oilChange)->format('j.n.Y') }}
                        @php $diff = Carbon\Carbon::parse($vehicle->oilChange)->diffInDays(now()->addDays(-1), true) @endphp
                        <span class="@if($diff < 30)text-orange-500 @else text-gray-500 dark:text-gray-400 @endif">
                            (za {{ floor(Carbon\Carbon::parse($vehicle->oilChange)->diffInDays(now()->addDays(-1), true)) }} dní)
                        </span>
                    @endif
                </dd>
            </div>
            <div class="flex flex-col pt-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Pojištění</dt>
                <dd class="text-lg font-semibold">
                    @if(empty($vehicle->insurance))
                        <em class="text-gray-400">--- Nevyplněno ---</em>
                    @elseif(Carbon\Carbon::parse($vehicle->insurance) < now())
                        <span class="font-bold text-red-500">
                            Po datu! <span class="text-gray dark:text-gray-400">({{ Carbon\Carbon::parse($vehicle->insurance)->format('j.n.Y') }})</span>
                        </span>
                    @else
                        {{ Carbon\Carbon::parse($vehicle->insurance)->format('j.n.Y') }}
                        @php $diff = Carbon\Carbon::parse($vehicle->insurance)->diffInDays(now()->addDays(-1), true) @endphp
                        <span class="@if($diff < 30)text-orange-500 @else text-gray-500 dark:text-gray-400 @endif'">
                            (za {{ floor(Carbon\Carbon::parse($vehicle->insurance)->diffInDays(now()->addDays(-1), true)) }} dní)
                        </span>
                    @endif
                </dd>
            </div>
            <div class="flex flex-col py-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Tachograf</dt>
                <dd class="text-lg font-semibold">
                    @if(empty($vehicle->tachograph))
                        <em class="text-gray-400">--- Nevyplněno ---</em>
                    @elseif(Carbon\Carbon::parse($vehicle->tachograph) < now())
                        <span class="font-bold text-red-500">
                            Po datu! <span class="text-gray dark:text-gray-400">({{ Carbon\Carbon::parse($vehicle->tachograph)->format('j.n.Y') }})</span>
                        </span>
                    @else
                        {{ Carbon\Carbon::parse($vehicle->tachograph)->format('j.n.Y') }}
                        @php $diff = Carbon\Carbon::parse($vehicle->tachograph)->diffInDays(now()->addDays(-1), true) @endphp
                        <span class="@if($diff < 30)text-orange-500 @else text-gray-500 dark:text-gray-400 @endif">
                            (za {{ floor(Carbon\Carbon::parse($vehicle->tachograph)->diffInDays(now()->addDays(-1), true)) }} dní)
                        </span>
                    @endif
                </dd>
            </div>
            <div class="flex flex-col py-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Letní pneu</dt>
                <dd class="text-lg font-semibold">
                    @if($vehicle->spneu)
                        @php $season = date('Y') - $vehicle->spneu + (date('n') > 4 || (date('n') == 4 && date('j') > 1) ? 1 : 0) @endphp
                        {{ $vehicle->spneu }} <span class="ml-1 badge @if($season >= 8)badge-red @elseif($season >= 5)badge-orange @endif">@if($season >= 7)<i class="fa-solid fa-triangle-exclamation mr-1"></i>@endif {{ $season }}. sezóna</span>
                    @else
                        <em class="text-gray-400">--- Nevyplněno ---</em>
                    @endif
                </dd>
            </div>
            <div class="flex flex-col py-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Zimní pneu</dt>
                <dd class="text-lg font-semibold">
                    @if($vehicle->wpneu)
                        @php $season = date('Y') - $vehicle->wpneu + (date('n') > 11 || (date('n') == 11 && date('j') > 1) ? 1 : 0) @endphp
                        {{ $vehicle->wpneu }} <span class="ml-1 badge @if($season >= 8)badge-red @elseif($season >= 5)badge-orange @endif">@if($season >= 7)<i class="fa-solid fa-triangle-exclamation mr-1"></i>@endif {{ $season }}. sezóna</span>
                    @else
                        <em class="text-gray-400">--- Nevyplněno ---</em>
                    @endif
                </dd>
            </div>
        </dl>

        <div class="mt-6 space-y-4">
            <a href="{{ route('vehicles.edit', ['vehicle' => $vehicle->id]) }}" class="button-black w-full">Upravit vozidlo</a>

            <form action="{{ route('vehicles.destroy', ['vehicle' => $vehicle->id]) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="button-red w-full" onclick="return confirm('Opravdu smazat vozidlo? Tato akce je nevratná.')">Smazat vozidlo</button>
            </form>
        </div>

    </div>
@endsection
