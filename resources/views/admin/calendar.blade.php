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

<section id="calendar" class="container my-4">
    <ol class="relative border-l border-gray-900">
        @foreach($orders as $order)
            <li class="mb-10 ml-6">
                <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-800 rounded-full -left-3 ring-8 ring-white">
                </span>
                <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900">{{$order->name}} {{--<span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ml-3">Latest</span>--}}</h3>
                <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ date('d.m.Y',strtotime($order->date)) }}</time>
                <p class="mb-2 text-base font-normal text-gray-500 dark:text-gray-400">{{ $order->description }}</p>
                <a href="/!/finishOrder/{{ $order->id }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border-2 border-green-800 rounded-lg"><i class="fa-solid fa-check-to-slot text-green-800 pe-2"></i> Hotovo</a>
            </li>
        @endforeach
    </ol>
    <hr class="my-2">
    <ol class="relative border-l border-gray-900">
        @foreach($fOrders as $fOrder)
            <li class="mb-10 ml-6">
                <span class="absolute flex items-center justify-center w-6 h-6 bg-green-800 rounded-full -left-3 ring-8 ring-white">
                </span>
                <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900">{{$fOrder->name}} {{--<span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ml-3">Latest</span>--}}</h3>
                <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ date('d.m.Y',strtotime($fOrder->date)) }}</time>
                <p class="mb-2 text-base font-normal text-gray-500 dark:text-gray-400">{{ $fOrder->description }}</p>
                <a href="/!/unfinishOrder/{{ $fOrder->id }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border-2 border-red-800 rounded-lg"><i class="fa-solid fa-check-to-slot text-red-800 pe-2"></i> Není hotovo</a>
            </li>
        @endforeach
    </ol>

</section>


<footer class="ud-footer">
    <div class="ud-footer-bottom">
        <div class="container">
            <div class="row">
                <p class="ud-footer-bottom-right text-center">
                    &copy; 2022 Martin Dub
                </p>
            </div>
        </div>
    </div>
</footer>

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
