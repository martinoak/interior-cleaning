@extends('layout')

@section('head')
    <!--====== OG META ======-->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://cisteni-kondrac.cz/">
    <meta property="og:title" content="Čištění interiérů Kondrac">
    <meta property="og:description" content="Vaše auto vyčistíme rychle, levně a kvalitně! Čištíme osobní automobily a používáme šetrné, ale účinné prostředky, aby se Vaše auto blyštilo.">
    <meta property="og:image" content="{{ asset('images/logo/logo-car2.png') }}">

    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.14" defer></script>
    <script src="https://www.google.com/recaptcha/api.js?render={{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></script>
    <script>
        grecaptcha.ready(function() {
            document.getElementById('demandForm').addEventListener("submit", function(event) {
                event.preventDefault();
                grecaptcha.execute({{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}, { action: 'contact' }).then(function(token) {
                    document.getElementById("recaptchaResponse").value= token;
                    document.getElementById('demandForm').submit();
                });
            }, false);
        });
    </script>
@endsection

@section('content')
<x-alert-bs />
<div id="vue-control">
    <!-- ====== Header Start ====== -->
    <header class="ud-header">
        <div class="container container-nav">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg">
                        <span class="navbar-brand">
                            <img src="{{ asset('images/logo/logo-car.png') }}" alt="Logo" class="w-100"/>
                        </span>
                        <a class="ud-logo-text navbar-brand-text fw-bold" href="{{ route('homepage') }}" style="color: white">
                            Čištění interiérů
                        </a>
                        <button class="navbar-toggler" aria-label="Menu" type="button">
                            <i class="fa-solid fa-bars text-white"></i>
                        </button>
                        <div class="navbar-collapse">
                            <ul id="nav" class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a class="ud-menu-scroll" href="#about">O nás</a>
                                </li>
                                <li class="nav-item">
                                    <a class="ud-menu-scroll" href="#cenik">Ceník</a>
                                </li>
                                <li class="nav-item">
                                    <a class="ud-menu-scroll" href="#reference">Reference</a>
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


    <section id="home" style="position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1;"></div>
        @php $fileName = 'hero-' . rand(1, 5) . '.mp4' @endphp
        <video autoplay muted loop playsinline id="hpVideo" style="width: 100%; object-fit: cover; z-index: 0;">
            <source src="{{ asset($fileName) }}" type="video/mp4">
        </video>
        <div class="container" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: white; z-index: 2;">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-hero-content">
                        <h1 class="ud-hero-title">
                            Čištění interiérů Kondrac
                        </h1>
                        <p class="ud-hero-desc">
                            Vaše auto vyčistíme rychle, levně a kvalitně!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


{{--
    <section class="ud-hero" id="home">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-hero-content">
                        <h1 class="ud-hero-title">
                            Čištění interiérů Kondrac
                        </h1>
                        <p class="ud-hero-desc">
                            Vaše auto vyčistíme rychle, levně a kvalitně!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
--}}

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
                <div class="ud-about-image-desktop" style="background-color: #3056d3">
                    <img src="{{ asset('images/logo/typography.png') }}" alt="about-image" style="margin-top: 25px;padding: 50px" />
                </div>
                <div class="ud-about-image-mobile" style="background-color: #3056d3">
                    <img src="{{ asset('images/logo/logo-car.png') }}" alt="about-image" style="padding: 20px 0;width: 20%" />
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
                        <hr>
                    </div>
                </div>
            </div>

            <div class="row g-0 align-items-center justify-content-center">
                @foreach($pricelist as $item => $values)
                    <div class="col-lg-4 col-md-10 col-sm-10">
                        <div class="ud-single-pricing @if($loop->first)first-item me-2 @elseif($loop->even) active @elseif($loop->last)last-item ms-2 @endif">
                            @if($loop->even) <span class="ud-popular-tag">Populární</span>  @endif
                            <div class="ud-pricing-header">
                                <h3>{{ strtoupper($item) }}</h3>
                                <h4>{{ $values['price'] }}</h4>
                            </div>
                            <div class="ud-pricing-body">
                                <ul>
                                    @for($i = 0; $i <= 9; $i++)
                                        @if(isset($values['description'][$i]))
                                            <li>{!! $values['description'][$i] !!}</li>
                                        @else
                                            <li>&nbsp;</li>
                                         @endif
                                    @endfor
                                </ul>
                            </div>
                            <div class="ud-pricing-footer">
                                <a href="#kontakt" class="ud-main-btn ud-border-btn" v-on:click="setVariant" data-variant="{{ $item }}">
                                    To beru!
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <p class="text-center">Za extra znečištěné auto může být účtován příplatek.</p>
                <p class="text-center">Ke každému čištění <span class="text-primary">malý dárek</span>.</p>
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
        </div>

        <div id="carouselExampleIndicators" class="d-none d-md-flex carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-inner w-50 mx-auto">
                @foreach($feedbacks as $feedback)
                    <div class="carousel-item @if($loop->first)active @endif">
                        <div class="d-block w-100">
                            <div class="ud-single-testimonial">
                                <div class="ud-testimonial-ratings">
                                    @if($feedback->rating == 1)
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
                                    <p>{{ $feedback->message }}</p>
                                </div>
                                <div class="ud-testimonial-info" style="justify-content: space-between">
                                    <div class="ud-testimonial-meta">
                                        <h3>{{ $feedback->name }}</h3>
                                        @if(isset($feedback->variant))
                                            <p>Varianta: {{ $feedback->variant }}</p>
                                        @endif
                                    </div>
                                    @if($feedback->fromGoogle)
                                        <img src="{{ asset('images/maps.svg') }}" class="ms-2" style="max-width: 100px; object-fit: contain" alt="">
                                     @endif
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

        <div id="carouselExampleIndicatorsMobile" class="d-flex d-md-none carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-inner w-75 mx-auto">
                @foreach($feedbacks as $feedback)
                    <div class="carousel-item @if($loop->first) active @endif">
                        <div class="d-block w-100">
                            <div class="ud-single-testimonial" style="padding: 20px">
                                <div class="ud-testimonial-ratings">
                                    {{ $feedback->rating }}<i class="ms-2 fa-solid fa-star"></i>
                                </div>
                                <div class="ud-testimonial-content">
                                    <p>{{ $feedback->message }}</p>
                                </div>
                                <div class="ud-testimonial-info" style="justify-content: space-between">
                                    <div class="ud-testimonial-meta">
                                        <h3>{{ $feedback->name }}</h3>
                                        @if(isset($feedback->variant))
                                            <p>Varianta: {{ $feedback->variant }}</p>
                                        @endif
                                    </div>
                                    @if($feedback->fromGoogle)
                                        <img src="{{ asset('images/maps.svg') }}" class="ms-2" style="max-width: 100px; object-fit: contain" alt="">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicatorsMobile" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicatorsMobile" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
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
                @foreach(config('web.team') as $worker)
                    <div class="col-xl-3 col-lg-3 col-sm-6">
                        <div class="ud-single-team">
                            <div class="ud-team-image-wrapper">
                                <div class="ud-team-image">
                                    <img src="{{ asset('images/team/team-01.png') }}" alt="team" />
                                </div>
                                <img src="{{ asset('images/team/dotted-shape.svg') }}" alt="shape" class="shape shape-1" />
                                <img src="{{ asset('images/team/shape-2.svg') }}" alt="shape" class="shape shape-2" />
                            </div>
                            <div class="ud-team-info">
                                <h3>{{ $worker['name'] }}</h3>
                                <h4>{{ $worker['position'] }}</h4>
                                <a href="tel:{{ str_replace(' ','', $worker['tel']) }}">{{ $worker['tel'] }}</a>
                            </div>
                            <ul class="ud-team-socials">
                                <li>
                                    <a href="{{ $worker['facebook'] }}" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="{{ $worker['instagram'] }}" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
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
                                    <h3>Adresa</h3>
                                    <p>Kondrac 115, 258 01 Vlašim</p>
                                    <a href="https://www.google.com/maps/dir/?api=1&travelmode=driving&layer=traffic&destination=49.665563,14.884062" class="py-1" target="_blank"><i class="fa-solid fa-location-arrow"></i> Pustit GPS</a>
                                </div>
                            </div>
                            <div class="ud-single-info">
                                <div class="ud-info-icon">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <div class="ud-info-meta">
                                    <h3>Spojme se!</h3>
                                    <a href="mailto:info@cisteni-kondrac.cz">info@cisteni-kondrac.cz</a>
                                    <a href="tel:+420602352402">+420 602 352 402</a>
                                </div>
                            </div>
                            <div class="ud-single-info">
                                <div class="ud-info-icon">
                                    <i class="fa-solid fa-briefcase"></i>
                                </div>
                                <div class="ud-info-meta">
                                    <h3>Firemní údaje</h3>
                                    <p><strong>IČO:</strong> 18026087</p>
                                    <p><strong>Sídlo:</strong> Kondrac 115</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="ud-contact-form-wrapper">
                        <h3 class="ud-contact-form-title">Napište nám! <i class="fa-solid fa-pen ms-2"></i></h3>
                        @foreach($errors->all() as $error)
                            <p style="color: red;margin-bottom: 5px">{{ $error }}</p>
                        @endforeach
                        <form id="demandForm" class="ud-contact-form" method="post" action="{{ route('sendEmail', ['sendEmail' => true]) }}">
                            @csrf
                            <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
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
                                <label for="telephone">Telefon <i class="fa-solid fa-star-of-life text-danger"></i></label>
                                <input
                                        type="text"
                                        name="telephone"
                                        id="telephone"
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
                            <input
                                    type="hidden"
                                    name="variant"
                                    :value="variant"
                                    placeholder=""
                            />
                            <div class="ud-form-group mb-0">
                                <button type="submit" class="ud-main-btn w-100 g-recaptcha" role="button" id="sendDemandButton">
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
</div>

<footer class="ud-footer">
    <div class="ud-footer-bottom">
        <div class="container">
            <div class="row">
                <p class="ud-footer-bottom-right text-center">
                    &copy; {{ date('Y') }} Martin Dub
                </p>
            </div>
        </div>
    </div>
</footer>

<a href="" class="back-to-top" aria-label="Back to top">
    <i class="fa-solid fa-chevron-up"></i>
</a>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('/js/main.js') }}" defer></script>
    <script>
        let video = document.getElementById("hpVideo");
        video.style.maxHeight = window.innerHeight + "px";
        video.style.minHeight = window.innerHeight + "px";
        video.onended = function() {
            video.play();
        };
    </script>
    <script type="text/javascript">
        document.getElementById("demandForm").addEventListener("submit", function() {
            document.getElementById("sendDemandButton").setAttribute("disabled", "disabled");
            setTimeout(function() {
                document.getElementById("sendDemandButton").removeAttribute("disabled");
            }, 2000);
        });
    </script>
    <script type="module">
        let vue = new Vue({
            el: '#vue-control',
            data: {
                variant: null,
            },
            methods: {
                setVariant: function (e) {
                    this.variant = e.target.dataset.variant;
                }
            }
        });
    </script>
@endsection
