@php $isDev = ! str_contains(url()->current(), 'cisteni-kondrac.cz') @endphp
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" />

    @livewireStyles

    @yield('head')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-zinc-800">
    <x-alert />

    @if($inAdmin)<x-sidebar :isDev="$isDev" />@endif

    <div>
        @if($inAdmin)<x-admin-header />@endif

            <div class="lg:pl-72">
                <main class="py-4">
                    <div class="px-4 sm:px-6 lg:px-8">
                        @yield('content')
                    </div>
                </main>
            </div>
    </div>

    @livewireScripts
</body>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>

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
