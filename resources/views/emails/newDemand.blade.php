<x-mail::message>
<h2><strong>{{ $variant ?? 'Bez varianty' }}</strong></h2><br>
{{ $name }}<br>
<a href="mailto:{{ $email }}">{{ $email }}</a><br>
<a href="tel:{{ $telephone }}">{{ $telephone }}</a><br>
<br>
{{ $message ?? '' }}<br>
<br>
<x-mail::button :url="$url">
Do administrace
</x-mail::button>

</x-mail::message>
