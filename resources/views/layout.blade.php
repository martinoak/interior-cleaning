@php $isDev = str_contains(url()->current(), 'mad.dek.cz') || str_contains(url()->current(), 'localhost') @endphp

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="title" content="Čištění interiérů Kondrac">
    <meta name="description" content="Vaše auto vyčistíme rychle, levně a kvalitně! Čištíme osobní automobily a používáme šetrné, ale účinné prostředky, aby se Vaše auto blyštilo.">
    <title>Čištění interiérů Kondrac</title>

    @if(! $isDev)
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-CH9KTSQLV2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-CH9KTSQLV2');
    </script>
    @endif

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>
    <link rel="apple-touch-icon" type="image/png" href="{{ asset('images/logo/apple.png') }}"/>

    <!-- ===== All CSS files ===== -->
    @if(url()->current() == route('homepage'))
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/ud-styles.css') }}?m={{ filemtime(public_path('css/ud-styles.css')) }}" />

    @yield('head')
</head>
<body style="overflow: hidden;overflow-y: scroll;box-sizing: content-box">
    @yield('content')
</body>
    @yield('scripts')
</html>
