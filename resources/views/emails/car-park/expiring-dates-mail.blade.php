<x-mail::message>
<h1><strong>Týdenní kontrola vozidel</strong></h1><br>
Vozidla, kterým do 30 dnů vyprší některý z termínů (STK, výměna oleje, tachograf a povinné ručení).<br>
<br>
@foreach($expiring as $type => $collection)
    @continue($collection->isEmpty())
    <h2><strong>{{ \App\Enums\CarParkDates::getTitle($type) }}</strong></h2>
    <x-mail::table>
        | Vozidlo       | SPZ           | Zbývá dní     |
        | :------------ | :-----------: | ------------: |
        @foreach($collection as $vehicle)
            @php $remaining = floor(abs($vehicle->$type->diffInDays(now()))); @endphp
            | {{ $vehicle->manufacturer }} {{ $vehicle->model }} | {{ $vehicle->spz }} | <span class="ml-1 badge @if($remaining <= 7)badge-red @else badge-orange @endif">{{ $remaining }} @if($remaining === 1) den @elseif($remaining < 4) dny @else dnů @endif</span> |
        @endforeach
    </x-mail::table>
@endforeach
<br>
</x-mail::message>
