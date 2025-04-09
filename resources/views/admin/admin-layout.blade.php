@php $isDev = str_contains(url()->current(), 'mad.dek.cz') || str_contains(url()->current(), 'localhost') @endphp
@php $inAdmin = str_contains(url()->current(), 'admin') @endphp

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="title" content="Čištění interiérů Kondrac">
    <meta name="description" content="Vaše auto vyčistíme rychle, levně a kvalitně! Čištíme osobní automobily a používáme šetrné, ale účinné prostředky, aby se Vaše auto blyštilo.">
    <title>Čištění interiérů Kondrac</title>

    @if (! $isDev)
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

    <!--====== Fonts ======-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100..700" rel="stylesheet">

    <!-- ===== All CSS files ===== -->
    @if(url()->current() == route('homepage'))
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

    <link rel="stylesheet" href="{{ asset('css/tailwind.css') . '?m=' . filemtime(public_path('css/tailwind.css')) }}" />

    @livewireStyles

    @yield('head')
</head>
<body class="bg-gray-50 dark:bg-gray-900" style="overflow: hidden;overflow-y: scroll;box-sizing: content-box">
    <x-alert />
    @if($inAdmin)<x-admin-sidebar :isDev="$isDev" />@endif
    <div>
        @if($inAdmin)<x-admin-header />@endif
        @yield('content')
    </div>

    @livewireScripts
</body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script>
        const moonButton = document.querySelector('#moonButton')
        const moonButtonMobile = document.querySelector('#moonButton-mobile')
        const sunButton = document.querySelector('#sunButton')
        const sunButtonMobile = document.querySelector('#sunButton-mobile')

        const theme = window.localStorage.getItem('theme')
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)')

        if (theme === 'dark' || (!('theme' in localStorage) && prefersDarkScheme.matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }

        moonButton.addEventListener('click', () => {
            document.documentElement.classList.add('dark')
            localStorage.setItem('theme', 'dark')
        })

        sunButton.addEventListener('click', () => {
            document.documentElement.classList.remove('dark')
            localStorage.setItem('theme', 'light')
        })

        moonButtonMobile.addEventListener('click', () => {
            document.documentElement.classList.add('dark')
            localStorage.setItem('theme', 'dark')
        })

        sunButtonMobile.addEventListener('click', () => {
            document.documentElement.classList.remove('dark')
            localStorage.setItem('theme', 'light')
        })
    </script>

    @yield('scripts')
</html>
