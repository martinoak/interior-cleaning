<x-mail::message>
<h1><strong>Souhrn tržeb</strong></h1><br>
Tržba za měsíc {{ date('m/Y') }}<br>
<h1 style="color: #1f6bd6">{{ $total }} Kč</h1><br>
<x-mail::button :url="$url">
    Do administrace
</x-mail::button>
</x-mail::message>
