<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="title" content="Čištění interiéru Kondrac">
    <meta name="description" content="Vaše auto vyčistíme rychle, levně a kvalitně! Čištíme osobní automobily a používáme šetrné, ale účinné prostředky, aby se Vaše auto blyštilo.">
    <title>Čištění interiéru Kondrac</title>

    <!--====== OG META ======-->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://cisteni-kondrac.cz/">
    <meta property="og:title" content="Čištění interiéru Kondrac">
    <meta property="og:description" content="Vaše auto vyčistíme rychle, levně a kvalitně! Čištíme osobní automobily a používáme šetrné, ale účinné prostředky, aby se Vaše auto blyštilo.">
    <meta property="og:image" content="">

    <!--====== Favicon Icon ======-->
    <link
        rel="shortcut icon"
        href="{{ asset('images/logo/logo-2.png') }}"
    />

    <!-- ===== All CSS files ===== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/ud-styles.css') }}" />

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
                                <a class="ud-menu-scroll" href="#about">O nás</a>
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
                        Vaše auto vyčistíme rychle, levně a kvalitně!
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="features" class="ud-features">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ud-section-title">
                    <span>Služby</span>
                    <h2>Tohle vše dokážeme zařídit</h2>
                    <hr />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-sm-6">
                <div class="ud-single-feature">
                    <div class="ud-feature-icon">
                        <i class="fa-solid fa-car"></i>
                    </div>
                    <div class="ud-feature-content">
                        <h3 class="ud-feature-title">Vnitřní úklid auta</h3>
                        <p class="ud-feature-desc">
                            Detailní luxování včetně zavazadlového prostoru a koberečků
                        </p>
                    </div>
                </div>
                <hr style="width: 50%">
            </div>
            <div class="col-xl-3 col-lg-3 col-sm-6">
                <div class="ud-single-feature">
                    <div class="ud-feature-icon">
                        <i class="fa-solid fa-soap"></i>
                    </div>
                    <div class="ud-feature-content">
                        <h3 class="ud-feature-title">Hloubkové čištění sedaček</h3>
                        <p class="ud-feature-desc">
                            Výkonným tepovačem a účinnými přípravky
                        </p>
                    </div>
                </div>
                <hr style="width: 50%">
            </div>
            <div class="col-xl-3 col-lg-3 col-sm-6">
                <div class="ud-single-feature">
                    <div class="ud-feature-icon">
                        <i class="fa-solid fa-shield-heart"></i>
                    </div>
                    <div class="ud-feature-content">
                        <h3 class="ud-feature-title">Oživení plastů</h3>
                        <p class="ud-feature-desc">
                            Očištění plastů v interiéru a jejich následné oživení
                        </p>
                        <hr style="width: 50%">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-sm-6">
                <div class="ud-single-feature">
                    <div class="ud-feature-icon">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div class="ud-feature-content">
                        <h3 class="ud-feature-title">A mnohem více!</h3>
                        <p class="ud-feature-desc">
                            Stačí kliknout na tlačítko níže a podívat se na ceník
                        </p>
                        <a href="#cenik" class="ud-feature-link text-primary">
                            Na ceník <i class="fa-solid fa-clipboard-list"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="about" class="ud-about">
    <div class="container">
        <div class="ud-about-wrapper">
            <div class="ud-about-content-wrapper">
                <div class="ud-about-content">
                    <span class="tag">O nás</span>
                    <h2>Mladí kluci s citem pro detail</h2>
                    <p>Svou dílnu máme v Kondraci, zastavte se!</p>
                    <p>Na čištění interiéru používáme šetrné, ale intenzivní prostředky, aby se Vaše auto blyštilo.</p>
                </div>
            </div>
            <div class="ud-about-image" style="width: 30%">
                <img src="assets/images" alt="about-image" />
            </div>
        </div>
    </div>
</section>

<section id="cenik" class="ud-pricing">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ud-section-title mx-auto text-center">
                    <span>Ceník</span>
                    <h2>Tak jak to dneska bude?</h2>
                    <hr />
                </div>
            </div>
        </div>

        <div class="row g-0 align-items-center justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-10">
                <div class="ud-single-pricing first-item me-2">
                    <div class="ud-pricing-header">
                        <h3>LEHKÝ START</h3>
                        <h4>499,- Kč</h4>
                    </div>
                    <div class="ud-pricing-body">
                        <ul>
                            <li>Základní luxování interiéru</li>
                            <li>Vyluxování zavazadlového prostoru</li>
                            <li>Vyluxování koberečků</li>
                            <li>Ošetření plastů proti poškrábání</li>
                            <li>Vyleštění čelního skla</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                        </ul>
                    </div>
                    <div class="ud-pricing-footer">
                        <a href="/variant/1" class="ud-main-btn ud-border-btn">
                            To beru!
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-10">
                <div class="ud-single-pricing active">
                    <span class="ud-popular-tag">Populární</span>
                    <div class="ud-pricing-header">
                        <h3>ZLATÁ STŘEDNÍ CESTA</h3>
                        <h4>1 799,- Kč</h4>
                    </div>
                    <div class="ud-pricing-body">
                        <ul>
                            <li><strong>Detailní</strong> luxování interiéru</li>
                            <li>Vyluxování zavazadlového prostoru</li>
                            <li>Vyčištění koberečků a umytí disků</li>
                            <li>Ošetření plastů proti poškrábání</li>
                            <li>Vyleštění oken a zrcátek</li>
                            <li>Tepování sedaček a koberečků</li>
                            <li>Desinfekce klimatizace</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                        </ul>
                    </div>
                    <div class="ud-pricing-footer">
                        <a href="/variant/2" class="ud-main-btn ud-white-btn">
                            To beru!
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-10">
                <div class="ud-single-pricing last-item ms-2">
                    <div class="ud-pricing-header">
                        <h3>DELUXE</h3>
                        <h4>2 999,- Kč</h4>
                    </div>
                    <div class="ud-pricing-body">
                        <ul>
                            <li><strong>Detailní</strong> luxování celého interiéru</li>
                            <li>Vyluxování zavazadlového prostoru</li>
                            <li>Vyčištění koberečků a umytí disků</li>
                            <li>Vyčištění a ošetření plastů proti poškrábání</li>
                            <li>Vyleštění všech skel z obou stran</li>
                            <li>Tepování sedaček a koberečků</li>
                            <li>Základní čištění kožených částí</li>
                            <li>Vyčištění klimatizace s vůní po citrónu</li>
                            <li>Navoskování čelního skla</li>
                        </ul>
                    </div>
                    <div class="ud-pricing-footer">
                        <a href="/variant/3" class="ud-main-btn ud-border-btn">
                            To beru!
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="reference" class="ud-testimonials">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ud-section-title mx-auto text-center">
                    <span>Reference</span>
                    <h2>Co o nás píší zákazníci</h2>
                    <hr />
                </div>
            </div>
        </div>

        <div id="carouselExampleIndicators" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-inner w-50 mx-auto">
                @foreach($feedbacks as $feedback)
                    <div class="carousel-item @if ($loop->first) active @endif">
                        <div class="d-block w-100">
                            <div class="ud-single-testimonial">
                                <div class="ud-testimonial-ratings">
                                    @if ($feedback->rating == 1)
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    @elseif($feedback->rating == 2)
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    @elseif($feedback->rating == 3)
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    @elseif($feedback->rating == 4)
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    @else
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    @endif
                                </div>
                                <div class="ud-testimonial-content">
                                    <p>{{$feedback->message}}</p>
                                </div>
                                <div class="ud-testimonial-info">
                                    <div class="ud-testimonial-meta">
                                        <h4>{{ $feedback->fullname }}</h4>
                                        <p>Varianta: {{ $feedback->variant }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
{{--
        <div class="row d-flex justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="ud-single-testimonial">
                    <div class="ud-testimonial-ratings">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <i class="fa-regular fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <div class="ud-testimonial-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl nec ultricies.</p>
                    </div>
                    <div class="ud-testimonial-info">
                        <div class="ud-testimonial-image">
                            <img src="{{ asset('images/testimonials/author-01.png') }}" alt=""/>
                        </div>
                        <div class="ud-testimonial-meta">
                            <h4>Martin Dub</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
--}}
    </div>
</section>

<section id="tym" class="ud-team">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="ud-section-title mx-auto text-center">
                    <span>Tým</span>
                    <h2>Ahoj!</h2>
                    <hr />
                </div>
            </div>
        </div>

        <div class="row justify-content-around">
            <div class="col-xl-3 col-lg-3 col-sm-6">
                <div class="ud-single-team">
                    <div class="ud-team-image-wrapper">
                        <div class="ud-team-image">
                            <img src="{{ asset('images/team/team-01.png') }}" alt="team" />
                        </div>
                        <img
                            src="{{ asset('images/team/dotted-shape.svg') }}"
                            alt="shape"
                            class="shape shape-1"
                        />
                        <img
                            src="{{ asset('images/team/shape-2.svg') }}"
                            alt="shape"
                            class="shape shape-2"
                        />
                    </div>
                    <div class="ud-team-info">
                        <h5>Štěpán Dub</h5>
                        <h6>Majitel</h6>
                        <a href="tel:+420602352402">+420 602 352 402</a>
                    </div>
                    <ul class="ud-team-socials">
                        <li>
                            <a href="/">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="/">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-sm-6">
                <div class="ud-single-team">
                    <div class="ud-team-image-wrapper">
                        <div class="ud-team-image">
                            <img src="{{ asset('images/team/team-01.png') }}" alt="team" />
                        </div>
                        <img
                            src="{{ asset('images/team/dotted-shape.svg') }}"
                            alt="shape"
                            class="shape shape-1"
                        />
                        <img
                            src="{{ asset('images/team/shape-2.svg') }}"
                            alt="shape"
                            class="shape shape-2"
                        />
                    </div>
                    <div class="ud-team-info">
                        <h5>Daniel Pohorský</h5>
                        <h6>Pracovník</h6>
                        <a href="tel:+420732790409">+420 732 790 409</a>
                    </div>
                    <ul class="ud-team-socials">
                        <li>
                            <a href="/">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="/">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="kontakt" class="ud-contact">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-8 col-lg-7">
                <div class="ud-contact-content-wrapper">
                    <div class="ud-section-title">
                        <span>Kontakt</span>
                        <h2>
                            Máte dotazy? <br />
                            Napište nebo zavolejte! Jsme tu pro Vás!
                        </h2>
                    </div>
                    <div class="ud-contact-info-wrapper">
                        <div class="ud-single-info">
                            <div class="ud-info-icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="ud-info-meta">
                                <h5>Adresa</h5>
                                <p>Kondrac 115, 258 01 Vlašim</p>
                                <a href="https://www.google.com/maps/dir/?api=1&travelmode=driving&layer=traffic&destination=49.665563,14.884062" class="py-1" target="_blank"><i class="fa-solid fa-location-arrow"></i> Pustit GPS</a>
                            </div>
                        </div>
                        <div class="ud-single-info">
                            <div class="ud-info-icon">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="ud-info-meta">
                                <h5>Spojme se!</h5>
                                <a href="mailto:info@cisteni-kondrac.cz">info@cisteni-kondrac.cz</a>
                            </div>
                        </div>
                        <div class="ud-single-info">
                            <div class="ud-info-icon">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="ud-info-meta">
                                <h5>Haló!</h5>
                                <a href="tel:+420602352402">+420 602 352 402</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                <div class="ud-contact-form-wrapper">
                    <h3 class="ud-contact-form-title">Napište nám! <i class="fa-solid fa-pen ms-2"></i></h3>
                    <form class="ud-contact-form" method="post" action="{{ route('sendEmail') }}">
                        {{ csrf_field() }}
                        <div class="ud-form-group">
                            <label for="name">Celé jméno <i class="fa-solid fa-star-of-life text-danger"></i></label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                placeholder="Jan Novák"
                                required
                            />
                        </div>
                        <div class="ud-form-group">
                            <label for="email">E-mail <i class="fa-solid fa-star-of-life text-danger"></i></label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                placeholder="jan@novak.cz"
                                required
                            />
                        </div>
                        <div class="ud-form-group">
                            <label for="phone">Telefon <i class="fa-solid fa-star-of-life text-danger"></i></label>
                            <input
                                type="text"
                                name="phone"
                                id="phone"
                                placeholder="+420 123 456 789"
                                required
                            />
                        </div>
                        <div class="ud-form-group">
                            <label for="message">Text zprávy</label>
                            <textarea
                                name="message"
                                id="message"
                                rows="1"
                                placeholder="Dobrý den..."
                            ></textarea>
                        </div>
                        @if (Session::has('variant'))
                        <div class="ud-form-group">
                            <label for="variant">Varianta <i class="fa-brands fa-angellist text-danger"></i></label>
                            <input
                                type="text"
                                name="variant"
                                id="variant"
                                value="{{ Session::get('variant') }}"
                                placeholder=""
                                required
                            />
                        </div>
                        @endif
                        <div class="ud-form-group mb-0">
                            <button type="submit" class="ud-main-btn w-100" role="button">
                                Odeslat poptávku
                            </button>
                            <p class="text-white text-center rounded-3 my-2 w-100" id="mailSuccess"></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

<a href="" class="back-to-top">
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
