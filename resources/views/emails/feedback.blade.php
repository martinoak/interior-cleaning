<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <title></title>
</head>

<body>
<h1>Dobrý den,</h1>
<p>Nedávno jste si nechal/a vyčistit své auto, snad jste spokojen/á.</p>
<p>Mohu Vás prostřednictvím tohoto e-mailu poprosit o vyplnění recenze? Zabere to pár sekund a mně to následně pomůže.</p>
<hr>
<p><a href="{{\Illuminate\Support\Facades\URL::to('/')}}/add-feedback?id={{md5(time())}}">Odkaz na napsání recenze</a></p>
<p>Odesláno @php echo date('d.n.Y \v H:i')@endphp</p>
<img src="https://github.com/MarvelousMartin/interior-cleaning/blob/master/public/images/logo/logo-2.png?raw=true"
     style="max-width: 100px" alt="Čistění interiéru Kondrac">
