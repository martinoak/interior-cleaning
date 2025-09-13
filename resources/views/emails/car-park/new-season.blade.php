<x-mail::message>
<h1><strong>Nová {{ $season === 'summer' ? 'letní' : 'zimní' }} sezóna!</strong></h1><br>
Zde je přehled pneumatik (pokud byl jejich rok výroby vyplněn) u jednotlivých aut a jejich sezóna.<br>
<br>
@foreach(\App\Models\Vehicle::all()->groupBy('type') as $type => $vehicles)
<h2><strong>{{ \App\Enums\VehicleType::from($type)->getName() }}</strong></h2>
    <x-mail::table>
        | Vozidlo       | SPZ           | {{ $season === 'summer' ? 'Letní' : 'Zimní' }} pneu |
        | :------------ | :-----------: | ------------: |
        @foreach($vehicles as $vehicle)
            @php $season = \App\Services\CarParkService::getTyreSeason($season === 'summer' ? $vehicle->spneu : $vehicle->wpneu) @endphp
            | {{ $vehicle->manufacturer }} {{ $vehicle->model }} | {{ $vehicle->spz }} | <span class="ml-1 badge @if($season >= 8) badge-red @elseif($season >= 5) badge-yellow @endif"> @if($season >= 6) <i class="fa-solid fa-triangle-exclamation mr-1"></i> @endif {{ $season }}. sezóna </span> |
        @endforeach
    </x-mail::table>
@endforeach
<br>
</x-mail::message>
