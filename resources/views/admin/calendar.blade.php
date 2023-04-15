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

    <!-- TODO nejakym zahadnym zpusobem tyto dva importy rozbiji scroll a navigace kvuli tomu blika -->
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.4/dist/flowbite.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
@include('partials.admin_header')

<section class="ud-hero" id="home">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ud-hero-content">
                    <h1 class="ud-hero-title">
                        Admin panel
                    </h1>
                    <p class="ud-hero-desc">
                        Kalendář
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="newEvent" class="container">
    <button type="submit" class="text-white bg-blue-700 font-medium rounded-lg text-sm py-2 px-3 my-2" data-modal-toggle="calendar-modal">Zadat práci do kalendáře</button>
    <div id="calendar-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-75">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal body -->
                <form action="/!/saveCalendarEvent" method="post">
                    {{ csrf_field() }}
                    <div class="p-6 space-y-6">
                        <div class="flex flex-col">
                            <label for="date" class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Datum úkolu <i class="fa-solid fa-asterisk text-red-600"></i></label>
                            <input type="date" name="date" id="date" class="border border-gray-300 px-4 py-2 rounded-lg" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="name" class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Jméno zákazníka <i class="fa-solid fa-asterisk text-red-600"></i></label>
                            <input type="text" name="name" id="name" class="border border-gray-300 px-4 py-2 rounded-lg" required>
                        </div>
                        <div class="flex flex-col">
                            <label for="message" class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Poznámka k úkolu</label>
                            <textarea rows="4" name="message" id="message" class="border border-gray-300 px-4 py-2 rounded-lg" required></textarea>
                        </div>
                        <div class="flex flex-col">
                            <label for="variant" class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Varianta <i class="fa-solid fa-asterisk text-red-600"></i></label>
                            <select id="variant" name="variant" class="border border-gray-300 px-4 py-2 rounded-lg">
                                <option value="1">Základ</option>
                                <option value="2">Zlatá střední cesta</option>
                                <option value="3">Deluxe</option>
                            </select>
                        </div>
                        <button type="submit" class="text-white bg-orange-500 font-medium rounded-lg text-sm py-2 px-3 mr-2 mb-2">Vytvořit úkol</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section id="calendar" class="container my-4">
    <ol class="relative border-l border-gray-900">
        @foreach($orders as $order)
            <li class="mb-10 ml-6">
                <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-800 rounded-full -left-3 ring-8 ring-white">
                </span>
                <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900">{{$order->name}}&nbsp;|&nbsp;<span class="text-gray-400">{{$order->variant}}</span></h3>
                <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ date('d.m.Y',strtotime($order->date)) }}</time>
                <p class="mb-2 text-base font-normal text-gray-500 dark:text-gray-400">{{ $order->description }}</p>
                <a href="/!/finishOrder/{{ $order->id }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border-2 border-green-800 rounded-lg"><i class="fa-solid fa-check text-green-800 pe-2"></i> Hotovo</a>
                <a href="/!/deleteCalendarNote/{{ $order->id }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border-2 border-red-800 rounded-lg"><i class="fa-solid fa-xmark text-red-800 pe-2"></i> Zrušit</a>
            </li>
        @endforeach
    </ol>
    <hr class="my-2">
    <ol class="relative border-l border-gray-900">
        @foreach($fOrders as $fOrder)
            <li class="mb-10 ml-6">
                <span class="absolute flex items-center justify-center w-6 h-6 bg-green-800 rounded-full -left-3 ring-8 ring-white">
                </span>
                <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900">{{$fOrder->name}}&nbsp;|&nbsp;<span class="text-gray-400">{{$fOrder->variant}} {{--<span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ml-3">Latest</span>--}}</h3>
                <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ date('d.m.Y',strtotime($fOrder->date)) }}</time>
                <p class="mb-2 text-base font-normal text-gray-500 dark:text-gray-400">{{ $fOrder->description }}</p>
                <a href="/!/unfinishOrder/{{ $fOrder->id }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border-2 border-red-800 rounded-lg"><i class="fa-solid fa-xmark text-red-800 pe-2"></i> Není hotovo</a>
                @if($fOrder->isInvoiceCreated)
                    <button class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border-2 border-gray-500 rounded-lg" disabled><i class="fa-solid fa-file-invoice text-gray-500 pe-2"></i> Fakturováno</button>
                @else
                    <button class="inline-flex items-center px-4 py-2 text-sm font-medium text-orange-500 bg-white border-2 border-orange-500 rounded-lg cursor-pointer" data-modal-toggle="invoice-{{$fOrder->id}}"><i class="fa-solid fa-file-invoice text-orange-500 pe-2"></i> Faktura</button>
                @endif
            </li>

            <div id="invoice-{{$fOrder->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                <div class="relative w-75">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal body -->
                        <form action="/!/saveInvoice" method="post">
                            {{ csrf_field() }}
                            <div class="p-6 space-y-6">
                                <input type="hidden" name="type" id="type" value="T">
                                <div class="flex flex-col">
                                    <label for="date" class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Datum provedení práce (lze i zpětně) <i class="fa-solid fa-asterisk text-red-600"></i></label>
                                    <input type="date" name="date" id="date" class="border border-gray-300 px-4 py-2 rounded-lg" required>
                                </div>
                                <div class="flex flex-col">
                                    <label for="name" class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Jméno zákazníka <i class="fa-solid fa-asterisk text-red-600"></i></label>
                                    <input type="text" name="name" id="name" value="{{$fOrder->name}}" class="border border-gray-300 px-4 py-2 rounded-lg" required>
                                </div>
                                <div class="flex flex-col">
                                    <label for="price" class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Cena <i class="fa-solid fa-asterisk text-red-600"></i></label>
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
        @endforeach
    </ol>

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
