<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Čištění interiéru Kondrac" />
    <title>Čištění interiéru Kondrac</title>

    <!--====== Favicon Icon ======-->
    <link
        rel="shortcut icon"
        href="{{ asset('images/logo/logo-2.png') }}"
    />

    <!-- ===== All CSS files ===== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/ud-styles.css') }}" />

    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.4/dist/flowbite.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
<header class="ud-header">
    <div class="container container-nav">
        <div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg">
                    <span class="navbar-brand">
                        <img src="{{ asset('images/logo/logo.png') }}" alt="Logo" class="w-100"/>
                    </span>
                    <a class="ud-logo-text navbar-brand-text fw-bold" href="/admin" style="color: white">
                        Admin panel
                    </a>
                    <button class="navbar-toggler">
                        <i class="fa-solid fa-bars text-white"></i>
                    </button>
                    @include ('partials.admin_nav')
                </nav>
            </div>
        </div>
    </div>
</header>

<section class="ud-hero" id="home">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ud-hero-content">
                    <h1 class="ud-hero-title">
                        Admin panel
                    </h1>
                    <p class="ud-hero-desc">
                        Zákazníci
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="customers" class="container my-4">
    @foreach($customers as $member)
        <div class="border border-gray-100 p-3 mb-3">
            <p class="fw-bold text-black">{{$member->fullname}}</p>
            <a href="mailto:{{$member->email}}" class="mb-2 underline font-medium text-blue-600">{{$member->email}}</a><br>
            <a href="tel:{{$member->telephone}}" class="mb-2 underline font-medium text-blue-600">{{$member->telephone}}</a>
            <p>{{$member->message}}</p>
            <div class="d-flex justify-content-between mt-3">
                @if($member->feedbackSent)
                    <button class="text-white bg-gray-700 font-medium rounded-lg text-sm py-2 px-3 mr-2 mb-2" disabled>
                        Feedback odeslán
                    </button>
                @else
                    <button class="text-white bg-blue-700 font-medium rounded-lg text-sm py-2 px-3 mr-2 mb-2" data-modal-toggle="feedbackModal-{{$member->email}}">
                        Feedback
                    </button>
                @endif
            </div>
        </div>

        <div id="feedbackModal-{{$member->email}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
            <div class="relative w-75">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                        <a href="/feedback?email={{$member->email}}&variant=1" class="w-100">
                            <button type="button" class="w-100 text-white bg-[#FF9119] font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-end mr-2 mb-2">
                                <i class="fa-solid fa-1 mr-5"></i>
                                Základ
                            </button>
                        </a>
                        <a href="/feedback?email={{$member->email}}&variant=2" class="w-100">
                            <button type="button" class="w-100 text-white bg-[#FF9119] font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-end mr-2 mb-2">
                                <i class="fa-solid fa-2 mr-5"></i>
                                Střed
                            </button>
                        </a>
                        <a href="/feedback?email={{$member->email}}&variant=3" class="w-100">
                            <button type="button" class="w-100 text-white bg-[#FF9119] font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-end mr-2 mb-2">
                                <i class="fa-solid fa-3 mr-5"></i>
                                Deluxe
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div id="order-{{$member->fullname}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
            <div class="relative w-75">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal body -->
                    <form action="/!/saveCustomer" method="post">
                        {{ csrf_field() }}
                        <!-- create form with required name, required date, description -->
                        <div class="p-6 space-y-6">
                            <div class="flex flex-col">
                                <label for="name" class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Jméno <i class="fa-solid fa-asterisk text-red-600"></i></label>
                                <input type="text" name="name" id="name" value="{{$member->fullname}}" class="border border-gray-300 px-4 py-2 rounded-lg" required>
                            </div>
                            <div class="flex flex-col">
                                <label for="email" class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Email <i class="fa-solid fa-asterisk text-red-600"></i></label>
                                <input type="email" name="email" id="email" value="{{$member->email}}" class="border border-gray-300 px-4 py-2 rounded-lg" required>
                            </div>
                            <div class="flex flex-col">
                                <label for="telephone" class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Telefon <i class="fa-solid fa-asterisk text-red-600"></i></label>
                                <input type="text" name="telephone" id="telephone" value="{{$member->telephone}}" class="border border-gray-300 px-4 py-2 rounded-lg" required>
                            </div>
                            <div class="flex flex-col">
                                <label for="message" class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Zpráva</label>
                                <textarea name="message" id="message" class="border border-gray-300 px-4 py-2 rounded-lg" rows="4">{{$member->message}}</textarea>
                            </div>
                            <div class="flex flex-col">
                                <label for="date" class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Datum <i class="fa-solid fa-asterisk text-red-600"></i></label>
                                <input type="date" name="date" id="date" class="border border-gray-300 px-4 py-2 rounded-lg" required>
                            </div>
                            <button type="submit" class="text-white bg-green-700 font-medium rounded-lg text-sm py-2 px-3 mr-2 mb-2">Objednat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</section>

@include('partials.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="https://unpkg.com/flowbite@1.5.4/dist/flowbite.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script>
    // ==== for menu scroll
    const pageLink = document.querySelectorAll(".ud-menu-scroll");
    pageLink.forEach((elem) => {
        elem.addEventListener("click", (e) => {
            e.preventDefault();
            document.querySelector(elem.getAttribute("href")).scrollIntoView({
                behavior: "smooth",
                offsetTop: 1 - 60,
            });
        });
    });
    // section menu active
    function onScroll() {
        const sections = document.querySelectorAll(".ud-menu-scroll");
        const scrollPos =
            window.scrollY ||
            document.documentElement.scrollTop ||
            document.body.scrollTop;
        for (let i = 0; i < sections.length; i++) {
            const currLink = sections[i];
            const val = currLink.getAttribute("href");
            const refElement = document.querySelector(val);
            const scrollTopMinus = scrollPos + 73;
            if (
                refElement.offsetTop <= scrollTopMinus &&
                refElement.offsetTop + refElement.offsetHeight > scrollTopMinus
            ) {
                document
                    .querySelector(".ud-menu-scroll")
                    .classList.remove("active");
                currLink.classList.add("active");
            } else {
                currLink.classList.remove("active");
            }
        }
    }
    window.document.addEventListener("scroll", onScroll);
</script>
</body>
</html>