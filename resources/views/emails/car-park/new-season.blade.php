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
        | {{ $vehicle->manufacturer }} {{ $vehicle->model }} | {{ $vehicle->spz }} | <x-badge :red="$season >= 8" :orange="$season >= 5" :text="{{ $season }} . '. sezóna'" /> |
        @endforeach
    </x-mail::table>
@endforeach
<br>
</x-mail::message>
