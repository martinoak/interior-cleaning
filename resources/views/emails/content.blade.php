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
<p>Telefon: {{ $details['phone'] }}</p>
<hr>
<p>{{ $details['message'] }}</p>

<img src="{{ asset('images/logo/logo-2.png') }}" alt="Čistění interiéru Kondrac">
