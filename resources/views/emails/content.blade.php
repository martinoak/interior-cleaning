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
<p>Varianta: @php if ($details['variant'] == 1) {echo "Lehký start";}elseif ($details['variant'] == 2) {echo "Zlatá střední cesta";}elseif ($details == 3) {echo "Deluxe";} else {echo 'Nebyla vybrána varianta';}@endphp</p>
<hr>
<p>{{ $details['message'] }}</p>
<p>Odesláno @php echo date('d.n.Y \v H:i')@endphp</p>
<img src="https://github.com/MarvelousMartin/interior-cleaning/blob/master/public/images/logo/logo-2.png?raw=true"
     style="max-width: 100px" alt="Čistění interiéru Kondrac">
