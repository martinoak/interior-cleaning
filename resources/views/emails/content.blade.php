<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <title>{{ $details['title'] }}</title>
</head>

<body>
<h1>{{ $details['title'] }}</h1>
<p>Jmeno: {{ $details['name'] }}</p>
<p>Email: {{ $details['email'] }}</p>
<p>Telefon: <a href="tel:{{$details['phone']}}">{{ $details['phone'] }}</a></p>
<p>Varianta: {{$details['variant']}}</p>
<hr>
<p>{{ $details['message'] }}</p>
<p>Odesláno @php echo date('d.n.Y \v H:i')@endphp</p>
<img src="https://github.com/MarvelousMartin/interior-cleaning/blob/master/public/images/logo/logo-2.png?raw=true"
     style="max-width: 100px" alt="Čistění interiérů Kondrac">
