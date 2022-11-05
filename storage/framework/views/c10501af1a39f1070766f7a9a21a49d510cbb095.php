<section id="kontakt" class="ud-contact">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-8 col-lg-7">
                <div class="ud-contact-content-wrapper">
                    <div class="ud-contact-title">
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
                                <p>Autodoprava Hana Houlíková</p>
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
                                <a href="mailto:cisteni.kondrac@gmail.com">cisteni.kondrac@gmail.com</a>
                            </div>
                        </div>
                        <div class="ud-single-info">
                            <div class="ud-info-icon">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="ud-info-meta">
                                <h5>Haló!</h5>
                                <a href="tel:+420602352402">+420 602 352 402</a>
                                <a href="tel:+420732790409">+420 732 790 409</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                <div class="ud-contact-form-wrapper">
                    <h3 class="ud-contact-form-title">Napište nám! <i class="fa-solid fa-pen ms-2"></i></h3>
                    <form class="ud-contact-form" method="post" id="form">
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
                            <label for="textmessage">Text zprávy</label>
                            <textarea
                                name="textmessage"
                                id="textmessage"
                                rows="1"
                                placeholder="Dobrý den..."
                            ></textarea>
                        </div>
                        <div class="ud-form-group mb-0">
                            <button type="submit" class="ud-main-btn w-100" id="submitButton" role="button">
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
<?php /**PATH C:\Users\Admin\Desktop\GitHub\interior-cleaning-laravel\resources\views/sections/contact.blade.php ENDPATH**/ ?>