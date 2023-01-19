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
                    <div class="navbar-collapse">
                        <ul id="nav" class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="fw-bold" href="/admin/customers">Zákazníci</a>
                            </li>
                            <li class="nav-item">
                                <a class="fw-bold" href="/admin/feedback">Recenze</a>
                            </li>
                            <li class="nav-item">
                                <a class="fw-bold" href="/admin/calendar">Kalendář</a>
                            </li>
                            <li class="nav-item">
                                <a class="fw-bold" href="/admin/invoices">Faktury</a>
                            </li>
                        {{--
                            <li class="nav-item">
                                <a class="ud-menu-scroll fw-bold" href="/admin/">Item</a>
                            </li>
                        --}}
                        </ul>
                    </div>
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
                        Faktury
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="invoices" class="container">
    <button type="submit" class="text-white bg-blue-700 font-medium rounded-lg text-sm py-2 px-3 my-2"data-modal-toggle="invoice-modal">Vytvořit fakturu mimo kontaktní formulář</button>
    <div id="invoice-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-75">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal body -->
                <form action="/!/saveInvoice" method="post">
                    {{ csrf_field() }}
                    <div class="p-6 space-y-6">
                        <div class="flex flex-col">
                            <label for="type" class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Typ faktury</label>
                            <select id="type" name="type" class="border border-gray-300 px-4 py-2 rounded-lg">
                                <option value="T">Tržba (dokončené čištění)</option>
                                <option value="N">Náklad (nákup prostředků)</option>
                                <option value="O">Ostatní</option>
                            </select>
                        </div>
                        <div class="flex flex-col">
                            <label for="date" class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Datum provedení práce (lze i zpětně) <i class="fa-solid fa-asterisk text-red-600"></i></label>
                            <input type="date" name="date" id="date" class="border border-gray-300 px-4 py-2 rounded-lg" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="name" class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Jméno na faktuře <i class="fa-solid fa-asterisk text-red-600"></i></label>
                            <input type="text" name="name" id="name" class="border border-gray-300 px-4 py-2 rounded-lg" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="price" class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Částka <i class="fa-solid fa-asterisk text-red-600"></i></label>
                            <input type="number" name="price" id="price" class="border border-gray-300 px-4 py-2 rounded-lg" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="worker" class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Pracovník</label>
                            <select id="worker" name="worker" class="border border-gray-300 px-4 py-2 rounded-lg">
                                <option value="Štěpán, Daniel">Štěpán, Daniel</option>
                                <option value="Štěpán">Štěpán</option>
                                <option value="Daniel">Daniel</option>
                            </select>
                        </div>
                        <button type="submit" class="text-white bg-orange-500 font-medium rounded-lg text-sm py-2 px-3 mr-2 mb-2">Vytvořit fakturu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach($invoices as $invoice)
        <div class="border border-gray-100 p-3 mb-3">
            <div class="p-3 bg-white rounded-lg flex flex-col md:flex-row justify-between">
                <div>
                    @if($invoice->type === 'T')
                        <i class="fa-solid fa-money-bills text-3xl text-gray-500 pe-4"></i>
                    @elseif($invoice->type === 'N')
                        <i class="fa-solid fa-cart-plus text-3xl text-gray-500 pe-4"></i>
                    @else
                        <i class="fa-solid fa-file-invoice text-3xl text-gray-500 pe-4"></i>
                    @endif
                    <span><h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900">{{$invoice->worker}}</h5></span>
                </div>
                <div class="flex gap-x-4">
                    <p class="mb-3 font-normal text-gray-500"><i class="fa-solid fa-user text-black"></i> {{$invoice->name}}</p>
                    <p class="mb-3 font-normal text-gray-500"><i class="fa-solid fa-calendar-days text-black"></i> {{date('d.m.Y', strtotime($invoice->date))}}</p>
                    <p class="mb-3 font-normal text-gray-500"><i class="fa-solid fa-hand-holding-dollar text-black"></i> {{$invoice->price}},- Kč</p>
                </div>
                <button type="button" class="focus:outline-none text-white bg-green-700 font-medium rounded-lg text-sm px-2 py-2.5 mr-2 mb-2">Vytvořit příjmový doklad</button>
            </div>
        </div>
    @endforeach
</section>


@include('partials.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="https://unpkg.com/flowbite@1.5.4/dist/flowbite.js"></script>
{{--<script src="{{ asset('js/main.js') }}"></script>--}}
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
