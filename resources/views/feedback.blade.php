<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Čištění interiéru Kondrac - recenze</title>

    <!--====== Favicon Icon ======-->
    <link
        rel="shortcut icon"
        href="{{ asset('images/logo/logo-2.png') }}"
    />

    <!-- ===== All CSS files ===== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/ud-styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

</head>
<body>
<!-- ====== Header Start ====== -->
<header class="ud-header">
    <div class="container container-nav">
        <div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg">
                    <span class="navbar-brand">
                        <img src="{{ asset('images/logo/logo.png') }}" alt="Logo" class="w-100"/>
                    </span>
                    <a class="ud-logo-text navbar-brand-text fw-bold" href="/" style="color: white">
                        Čištění interiéru
                    </a>
                    <button class="navbar-toggler">
                        <i class="fa-solid fa-bars text-white"></i>
                    </button>
                    <div class="navbar-collapse">
                        <ul id="nav" class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="ud-menu-scroll" href="#about">O mně</a>
                            </li>
                            <li class="nav-item">
                                <a class="ud-menu-scroll" href="#reference">Reference</a>
                            </li>
                            <li class="nav-item">
                                <a class="ud-menu-scroll" href="#cenik">Ceník</a>
                            </li>
                            <li class="nav-item">
                                <a class="ud-menu-scroll" href="#tym">Tým</a>
                            </li>
                            <li class="nav-item">
                                <a class="ud-menu-scroll fw-bold" href="#kontakt">Kontakty</a>
                            </li>
                            {{--<li class="nav-item">
                                <a class="ud-menu-scroll" onclick="window.location.href='/tailwind'">Tailwind</a>
                            </li>--}}
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
                        Čištění interiéru Kondrac
                    </h1>
                    <p class="ud-hero-desc">
                        Recenze
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="feedback-form" class="container my-5">
    <form method="post" action="/!/save-feedback">
        {{ csrf_field() }}
        <div class="form-group my-2">
            <label for="name">Jméno a příjmení</label>
            <input type="text" class="form-control" id="name" name="fullname">
            <small id="emailHelp" class="form-text text-muted text-sm opacity-50">Vyplněním jména souhlasíte s jeho zveřejněním na domovské stránce.</small>
        </div>
        <div class="form-group my-2">
            <input type="hidden" class="form-control" id="variant" name="variant" value="TODO" readonly>
        </div>
        <div class="form-group my-2">
            <label for="message">Text recenze</label>
            <textarea class="form-control" id="message" name="message" rows="3"></textarea>
        </div>

        <div class="rating">
            <label>
                <input type="radio" name="stars" value="1" />
                <span class="icon"><i class="fa-regular fa-star"></i></span>
            </label>
            <label>
                <input type="radio" name="stars" value="2" />
                <span class="icon"><i class="fa-regular fa-star"></i></span>
                <span class="icon"><i class="fa-regular fa-star"></i></span>
            </label>
            <label>
                <input type="radio" name="stars" value="3" />
                <span class="icon"><i class="fa-regular fa-star"></i></span>
                <span class="icon"><i class="fa-regular fa-star"></i></span>
                <span class="icon"><i class="fa-regular fa-star"></i></span>
            </label>
            <label>
                <input type="radio" name="stars" value="4" />
                <span class="icon"><i class="fa-regular fa-star"></i></span>
                <span class="icon"><i class="fa-regular fa-star"></i></span>
                <span class="icon"><i class="fa-regular fa-star"></i></span>
                <span class="icon"><i class="fa-regular fa-star"></i></span>
            </label>
            <label>
                <input type="radio" name="stars" value="5" />
                <span class="icon"><i class="fa-regular fa-star"></i></span>
                <span class="icon"><i class="fa-regular fa-star"></i></span>
                <span class="icon"><i class="fa-regular fa-star"></i></span>
                <span class="icon"><i class="fa-regular fa-star"></i></span>
                <span class="icon"><i class="fa-regular fa-star"></i></span>
            </label>
        </div>
        <div class="form-group my-2">
            <input class="form-control" type="hidden" name="hash" value="{{$hash}}">
        </div>
        <button type="submit" class="btn btn-primary">Odeslat recenzi</button>
    </form>
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

<a href="javascript:void(0)" class="back-to-top">
    <i class="fa-solid fa-chevron-up"></i>
</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" defer></script>
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
