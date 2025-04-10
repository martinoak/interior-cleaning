@extends('admin/admin-layout')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="heading justify-between">
            <a href="{{ route('vehicles.index') }}" class="button-indigo" type="button">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </a>
            <h1 class="heading-title">{{ $vehicle->manufacturer }} {{ $vehicle->model }}</h1>
            <aside class="flex gap-4">
                <a href="{{ route('service-book.index', ['vehicle' => $vehicle->id]) }}" class="button-black">
                    <i class="fa-solid fa-wrench fa-lg"></i>
                </a>
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
                        <button type="button"
                                class="ml-2 button-indigo"
                                onclick="navigator.clipboard.writeText('{{ $vehicle->vin }}')"
                        >
                            <i class="fa-regular fa-paste fa-lg"></i>
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
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Barva</dt>
                <dd class="text-lg font-semibold">
                    <div class="w-full h-8 rounded-lg" style="background-color: {!! $vehicle->color !!}"></div>
                </dd>
            </div>
            @foreach ($dates as $type)
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">{{ \App\Enums\CarParkDates::from($type)->getTitle() }}</dt>
                    <dd class="text-lg font-semibold">
                        @if($vehicle->$type)
                            {{ Carbon\Carbon::parse($vehicle->$type)->format('j.n.Y') }}
                            <x-badge
                                :red="in_array(floor(Carbon\Carbon::parse($vehicle->$type)->diffInDays()), range(-7, 0))"
                                :orange="in_array(floor(Carbon\Carbon::parse($vehicle->$type)->diffInDays()), range(-60, -8))"
                                :triangle="in_array(floor(Carbon\Carbon::parse($vehicle->$type)->diffInDays()), range(-7, 0))"
                                :text="floor(Carbon\Carbon::parse($vehicle->$type)->diffInDays(now()->addDays(-1), true)) . ' dní'"
                            />
                        @else
                            <em class="text-gray-400">--- Nevyplněno ---</em>
                        @endif
                    </dd>
                </div>
            @endforeach
            <div class="flex flex-col py-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Letní pneu</dt>
                <dd class="text-lg font-semibold">
                    @if($vehicle->spneu)
                        @php $season = \App\Services\CarParkService::getTyreSeason($vehicle->spneu) @endphp
                        {{ $vehicle->spneu }}
                        <x-badge :red="$season >= 8" :orange="$season >= 5" :triangle="$season >= 7" :text="$season . '. sezóna'" />
                    @else
                        <em class="text-gray-400">--- Nevyplněno ---</em>
                    @endif
                </dd>
            </div>
            <div class="flex flex-col py-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Zimní pneu</dt>
                <dd class="text-lg font-semibold">
                    @if($vehicle->wpneu)
                        @php $season = \App\Services\CarParkService::getTyreSeason($vehicle->wpneu) @endphp
                        {{ $vehicle->wpneu }}
                        <x-badge :red="$season >= 8" :orange="$season >= 5" :triangle="$season >= 7" :text="$season . '. sezóna'" />
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
