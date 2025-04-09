<x-mail::message>
<h1><strong>Itinerář</strong></h1>
<h2>{{ date('j.n.Y') }}</h2>
<p>
    @foreach($customers as $customer)
        <strong>Jméno: </strong> {{ $customer->name }}<br>
        <strong>Telefon: </strong> <a href="tel:{{ $customer->telephone }}">{{ $customer->telephone }}</a><br>
        <strong>Varianta: </strong> {{ $customer->variant }}<br>
        <strong>Zpráva: </strong> {{ $customer->message ?? '' }}<br>
        @if(! $loop->last)
            <hr>
        @endif
    @endforeach
</p>
</x-mail::message>
