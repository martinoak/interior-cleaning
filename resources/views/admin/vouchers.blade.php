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
                        Vouchery
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="vouchers" class="container md:w-1/2">
    @if(!(isset($voucher) || isset($checkedVoucher)))
        <div class="flex flex-col md:flex-row md:justify-center gap-x-8">
            <div id="voucher-10" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                <div class="relative w-75">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal body -->
                        <div class="flex-col justify-center space-y-4">
                            <p class="w-full text-center">{{$hex}}</p>
                            <div class="flex justify-center gap-x-4">
                                <a href="/!/saveMiniVoucher/{{$hex}}">
                                    <button type="button" class="w-100 text-white bg-[#FF9119] font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-end mr-2 mb-2">
                                        <i class="fa-solid fa-save mr-2"></i>
                                        <span>Uložit voucher</span>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="text-white bg-green-700 font-medium rounded-lg text-sm py-2 px-5 my-2" data-modal-toggle="voucher-10">10% sleva</button>
            <button type="submit" class="text-white bg-blue-700 font-medium rounded-lg text-sm py-2 px-5 my-2" data-modal-toggle="voucher-modal">Založit voucher</button>
        </div>

        <div id="voucher-verify" class="container">
            <form action="/!/validateVoucher" method="post">
                {{ csrf_field() }}
                <div class="p-6 space-y-6">
                    <div class="flex flex-col">
                        <label for="hash" class="mb-2 text-sm font-medium text-gray-600">Kód voucheru <i class="fa-solid fa-asterisk text-red-600"></i></label>
                        <input type="text" name="hash" id="hash" class="border border-gray-300 px-4 py-2 rounded-lg" required>
                    </div>
                    <div class="flex flex-col">
                        <label for="price" class="mb-2 text-sm font-medium text-gray-600">Cena <i class="fa-solid fa-asterisk text-red-600"></i></label>
                        <input type="number" name="price" id="price" class="border border-gray-300 px-4 py-2 rounded-lg" required>
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" class="text-white bg-red-500 font-medium rounded-lg text-sm py-2 px-3 mr-2 mb-2">Ověřit voucher</button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    <div id="voucher-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-75">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <a href="/!/storeVoucher?price=500" class="w-100">
                        <button type="button" class="w-100 text-white bg-[#FF9119] font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-end mr-2 mb-2">
                            <i class="fa-solid fa-1 mr-5"></i>
                            Lehký start
                        </button>
                    </a>
                    <a href="/!/storeVoucher?price=1800" class="w-100">
                        <button type="button" class="w-100 text-white bg-[#FF9119] font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-end mr-2 mb-2">
                            <i class="fa-solid fa-2 mr-5"></i>
                            Zlatá střední cesta
                        </button>
                    </a>
                    <a href="/!/storeVoucher?price=3000" class="w-100">
                        <button type="button" class="w-100 text-white bg-[#FF9119] font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-end mr-2 mb-2">
                            <i class="fa-solid fa-3 mr-5"></i>
                            Deluxe
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(isset($voucher))
        <div class="flex flex-col bg-green-100 border border-green-400 text-green-700 px-4 py-3 my-3 rounded relative text-center">
            <div class="flex justify-center items-center">
                <div>
                    <strong class="font-bold">Voucher byl úspěšně vytvořen!</strong><br>
                    <span class="block sm:inline">Kód: {{ $voucher['hash'] }}</span><br>
                    <span class="block sm:inline">Platnost do: {{ str_replace('-', '.', $voucher['date']) }}</span><br>
                    <span class="block sm:inline">Cena: {{ $voucher['price'] }},- Kč</span>
                </div>
            </div>
            <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative text-center fw-bold my-1">Voucher bude po odkliknutí skryt!!</p>
            <div>
                <a href="/admin/vouchers"><button class="text-white bg-green-900 font-medium rounded-lg text-sm py-2 px-3 my-2">Zapsal jsem si údaje.</button></a>
                <a href="/admin/showVoucher?price={{$voucher['price']}}"><button class="text-white bg-amber-700 font-medium rounded-lg text-sm py-2 px-3 my-2">Zobrazit voucher</button></a>
            </div>
        </div>
    @endif
        @if(isset($checkedVoucher))
            <div class="flex flex-col bg-{{$checkedVoucher['status']}}-100 border border-{{$checkedVoucher['status']}}-400 text-{{$checkedVoucher['status']}}-700 px-4 py-3 my-3 rounded relative text-center">
                <div class="flex justify-center items-center">
                    <div>
                        <strong class="font-bold">{{ $checkedVoucher['message'] }}</strong><br>
                    </div>
                </div>
                @if($checkedVoucher['status'] == 'green')
                    <div>
                        <a href="/!/useVoucher?hash={{ $checkedVoucher['hash'] }}"><button class="text-white bg-green-900 font-medium rounded-lg text-sm py-2 px-3 my-2">Uplatnit voucher (Voucher se bude ukazovat jako využitý).</button></a>
                    </div>
                @endif
                <div>
                    <a href="/admin/vouchers"><button class="text-white bg-blue-700 font-medium rounded-lg text-sm py-2 px-3 my-2">Beru na vědomí.</button></a>
                </div>
            </div>

        @endif
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
