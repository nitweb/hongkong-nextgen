@extends('frontend.dashboard')
@section('frontend_title', 'Home')
@section('frontend_contents')

    <!--Main Slider Start-->
    <section class="main-slider-two clearfix">
        <div class="swiper-container thm-swiper__slider" data-swiper-options='{"slidesPerView": 1, "loop": true,
                "effect": "fade",
                "pagination": {
                "el": "#main-slider-pagination",
                "type": "bullets",
                "clickable": true
                },
                "navigation": {
                "nextEl": "#main-slider__swiper-button-next",
                "prevEl": "#main-slider__swiper-button-prev"
                },
                "autoplay": {
                "delay": 5000
                }}'>
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="image-layer-two" style="background-image: url(assets/images/backgrounds/main-slider-1-2.jpg);"></div>
                    <!-- /.image-layer -->
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="main-slider-two__content">
                                    <p class="main-slider-two__sub-title">Profesional Repair</p>
                                    <h2 class="main-slider-two__title">We Are Experts At <br> Cell Phone Repair!
                                    </h2>
                                    <p class="main-slider-two__text">Lorem ipsum dolor sit amet, consectetur
                                        adipiscing elit, sed do eiusmod <br> tempor incididunt ut labore et dolore
                                        magna aliqua.</p>
                                    <div class="main-slider-two__btn-box">
                                        <a href="services.html" class="thm-btn main-slider-two__btn">Repair My
                                            Device</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="image-layer-two" style="background-image: url(assets/images/backgrounds/main-slider-1-1.jpg);"></div>
                    <!-- /.image-layer -->
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="main-slider-two__content">
                                    <p class="main-slider-two__sub-title">Profesional Repair</p>
                                    <h2 class="main-slider-two__title">We Are Experts At <br> Cell Phone Repair!
                                    </h2>
                                    <p class="main-slider-two__text">Lorem ipsum dolor sit amet, consectetur
                                        adipiscing elit, sed do eiusmod <br> tempor incididunt ut labore et dolore
                                        magna aliqua.</p>
                                    <div class="main-slider-two__btn-box">
                                        <a href="services.html" class="thm-btn main-slider-two__btn">Repair My
                                            Device</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="image-layer-two" style="background-image: url(assets/images/backgrounds/main-slider-1-3.jpg);"></div>
                    <!-- /.image-layer -->
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="main-slider-two__content">
                                    <p class="main-slider-two__sub-title">Profesional Repair</p>
                                    <h2 class="main-slider-two__title">We Are Experts At <br> Cell Phone Repair!
                                    </h2>
                                    <p class="main-slider-two__text">Lorem ipsum dolor sit amet, consectetur
                                        adipiscing elit, sed do eiusmod <br> tempor incididunt ut labore et dolore
                                        magna aliqua.</p>
                                    <div class="main-slider-two__btn-box">
                                        <a href="services.html" class="thm-btn main-slider-two__btn">Repair My
                                            Device</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <!-- If we need navigation buttons -->
            <div class="main-slider-two__nav">
                <div class="swiper-button-prev" id="main-slider__swiper-button-next">
                    <i class="icon-left-arrow"></i>
                </div>
                <div class="swiper-button-next" id="main-slider__swiper-button-prev">
                    <i class="icon-right-arrow"></i>
                </div>
            </div>

        </div>
    </section>
    <!--Main Slider End-->

    <!--Experience One Start-->
    <section class="experience-one experience-two">
        <div class="experience-two-shape-1 float-bob-y" style="background-image: url(assets/images/shapes/experience-two-shape-1.jpg);"></div>
        <div class="container">
            <div class="section-title text-center">
                <span class="section-title__tagline">About Experience</span>
                <h2 class="section-title__title">We Have Than 20 Years Experience in Gadget
                    <br>Smartphone & Laptop Repair Services
                </h2>
            </div>
            <div class="row">
                <!--Experience One Single Start-->
                <div class="col-xl-4 col-lg-4 wow fadeInLeft" data-wow-delay="100ms">
                    <div class="experience-one__single">
                        <div class="experience-one__icon">
                            <span class="icon-service"></span>
                        </div>
                        <div class="experience-one__content">
                            <h3 class="experience-one__title"><a href="services-details.html">Quality Services</a>
                            </h3>
                            <p class="experience-one__text">Duis aute irure dolor in voluptate velit esse cillum
                                dolore eu fugiat nulla pariatur. </p>
                        </div>
                    </div>
                </div>
                <!--Experience One Single End-->
                <!--Experience One Single Start-->
                <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="200ms">
                    <div class="experience-one__single">
                        <div class="experience-one__icon">
                            <span class="icon-management"></span>
                        </div>
                        <div class="experience-one__content">
                            <h3 class="experience-one__title"><a href="team.html">Professional Team</a></h3>
                            <p class="experience-one__text">Duis aute irure dolor in voluptate velit esse cillum
                                dolore eu fugiat nulla pariatur. </p>
                        </div>
                    </div>
                </div>
                <!--Experience One Single End-->
                <!--Experience One Single Start-->
                <div class="col-xl-4 col-lg-4 wow fadeInRight" data-wow-delay="300ms">
                    <div class="experience-one__single">
                        <div class="experience-one__icon">
                            <span class="icon-headphones"></span>
                        </div>
                        <div class="experience-one__content">
                            <h3 class="experience-one__title"><a href="contact.html">24 Hour Support</a></h3>
                            <p class="experience-one__text">Duis aute irure dolor in voluptate velit esse cillum
                                dolore eu fugiat nulla pariatur. </p>
                        </div>
                    </div>
                </div>
                <!--Experience One Single End-->
            </div>
        </div>
    </section>
    <!--Experience One End-->

    <!--Services Two Start-->
    <section class="services-two">
        <div class="container">
            <div class="section-title section-title--two text-center">
                <span class="section-title__tagline">OUR SERVICES</span>
                <h2 class="section-title__title">Our Efficient Solution</h2>
                <p class="section-title__text">Duis aute irure dolor in repreh enderit in volup tate velit esse
                    cillum dolore <br> eu fugiat nulla dolor atur with Lorem ipsum is simply</p>
            </div>
            <div class="row">
                <!--Services Two Single Start-->
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                    <div class="services-two__single">
                        <div class="services-two__single-inner">
                            <div class="services-two__icon">
                                <span class="icon-phone"></span>
                            </div>
                            <h3 class="services-two__title"><a href="services-details.html">Mobile Phone</a></h3>
                            <p class="services-two__text">Duis aute irure dolor in repreh enderit in volup tate
                                velit esse cillum dolore fugiat nulla dolor atur</p>
                        </div>
                    </div>
                </div>
                <!--Services Two Single End-->
                <!--Services Two Single Start-->
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                    <div class="services-two__single">
                        <div class="services-two__single-inner">
                            <div class="services-two__icon services-two__icon--two">
                                <span class="icon-tap"></span>
                            </div>
                            <h3 class="services-two__title"><a href="services-details.html">Tablet</a></h3>
                            <p class="services-two__text">Duis aute irure dolor in repreh enderit in volup tate
                                velit esse cillum dolore fugiat nulla dolor atur</p>
                        </div>
                    </div>
                </div>
                <!--Services Two Single End-->
                <!--Services Two Single Start-->
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                    <div class="services-two__single">
                        <div class="services-two__single-inner">
                            <div class="services-two__icon services-two__icon--three">
                                <span class="icon-laptop"></span>
                            </div>
                            <h3 class="services-two__title"><a href="services-details.html">Laptop</a></h3>
                            <p class="services-two__text">Duis aute irure dolor in repreh enderit in volup tate
                                velit esse cillum dolore fugiat nulla dolor atur</p>
                        </div>
                    </div>
                </div>
                <!--Services Two Single End-->
                <!--Services Two Single Start-->
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="400ms">
                    <div class="services-two__single">
                        <div class="services-two__single-inner">
                            <div class="services-two__icon services-two__icon--three">
                                <span class="icon-computer"></span>
                            </div>
                            <h3 class="services-two__title"><a href="services-details.html">Computer Desktop</a>
                            </h3>
                            <p class="services-two__text">Duis aute irure dolor in repreh enderit in volup tate
                                velit esse cillum dolore fugiat nulla dolor atur</p>
                        </div>
                    </div>
                </div>
                <!--Services Two Single End-->
                <!--Services Two Single Start-->
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="500ms">
                    <div class="services-two__single">
                        <div class="services-two__single-inner">
                            <div class="services-two__icon">
                                <span class="icon-camera"></span>
                            </div>
                            <h3 class="services-two__title"><a href="services-details.html">Camera</a></h3>
                            <p class="services-two__text">Duis aute irure dolor in repreh enderit in volup tate
                                velit esse cillum dolore fugiat nulla dolor atur</p>
                        </div>
                    </div>
                </div>
                <!--Services Two Single End-->
                <!--Services Two Single Start-->
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="600ms">
                    <div class="services-two__single">
                        <div class="services-two__single-inner">
                            <div class="services-two__icon services-two__icon--two">
                                <span class="icon-smartwatch"></span>
                            </div>
                            <h3 class="services-two__title"><a href="services-details.html">Wearable Device</a></h3>
                            <p class="services-two__text">Duis aute irure dolor in repreh enderit in volup tate
                                velit esse cillum dolore fugiat nulla dolor atur</p>
                        </div>
                    </div>
                </div>
                <!--Services Two Single End-->
            </div>
        </div>
    </section>
    <!--Services Two End-->

    <!--About Two Start-->
    <section class="about-two">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6">
                    <div class="about-two__left">
                        <div class="about-two__main-progress-box">
                            <div class="about-two__progress-single">
                                <div class="about-two__progress-box">
                                    <div class="circle-progress" data-options='{ "value": 0.8,"thickness": 10,"emptyFill": "#f1f1f1","lineCap": "square", "size": 110, "fill": { "color": "#cf1f1f" } }'>
                                    </div><!-- /.circle-progress -->
                                    <div class="about-two__pack">
                                        <p>85%</p>
                                    </div>
                                </div>
                                <div class="about-two__progress-content">
                                    <p>Repair Device</p>
                                </div>
                            </div>
                            <div class="about-two__progress-single">
                                <div class="about-two__progress-box">
                                    <div class="circle-progress" data-options='{ "value": 0.9,"thickness": 10,"emptyFill": "#f1f1f1","lineCap": "square", "size": 110, "fill": { "color": "#cf1f1f" } }'>
                                    </div><!-- /.circle-progress -->
                                    <div class="about-two__pack">
                                        <p>95%</p>
                                    </div>
                                </div>
                                <div class="about-two__progress-content">
                                    <p>Replace Device</p>
                                </div>
                            </div>
                        </div>
                        <div class="about-two__img-box">
                            <div class="about-two__img">
                                <img src="assets/images/resources/about-2-1.jpg" alt="">
                            </div>
                            <div class="about-two__img-two">
                                <img src="assets/images/resources/about-2-2.jpg" alt="">
                                <div class="about-two__video-link">
                                    <a href="https://www.youtube.com/watch?v=Get7rqXYrbQ" class="video-popup">
                                        <div class="about-two__video-icon">
                                            <span class="fa fa-play"></span>
                                            <i class="ripple"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="about-two__shape-1 shapeMover">
                            <img src="assets/images/shapes/about-two-shape-1.png" alt="">
                        </div>
                        <div class="about-two__shape-2 float-bob-y">
                            <img src="assets/images/shapes/about-two-shape-2.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6">
                    <div class="about-two__right">
                        <div class="section-title text-left">
                            <span class="section-title__tagline">Quality Repair</span>
                            <h2 class="section-title__title">We Can Fix It Almost As Fast
                                As You Can Break It.</h2>
                        </div>
                        <p class="about-two__text-1">Duis aute irure dolor in repreh enderit in volup tate velit
                            esse cillum dolore</p>
                        <ul class="list-unstyled about-two__points">
                            <li>
                                <div class="icon">
                                    <span class="icon-award"></span>
                                </div>
                                <div class="text">
                                    <p>WE ALWAYS PUT QUALITY FIRST</p>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <span class="icon-community"></span>
                                </div>
                                <div class="text">
                                    <p>CUSTOMER SATISFACTION IS ABSOLUTE</p>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <span class="icon-warranty"></span>
                                </div>
                                <div class="text">
                                    <p>FAST AND QUALITY WORK</p>
                                </div>
                            </li>
                        </ul>
                        <p class="about-two__text-2">Duis aute irure dolor in repreh enderit in volup tate velit
                            esse cillum dolore eu fugiat nulla dolor atur with Lorem ipsum is simply free text
                            market web bites eius mod ut labore duis aute irure pari</p>
                        <a href="contact.html" class="thm-btn">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--About Two  End-->

    <!--Contact Two Start-->
    <section class="contact-two">
        <div class="contact-two-bg jarallax" data-jarallax data-speed="0.2" data-imgPosition="50% 0%" style="background-image: url(assets/images/backgrounds/contact-two-bg.jpg);"></div>
        <div class="container">
            <div class="contact-two__inner">
                <div class="section-title section-title--two text-center">
                    <span class="section-title__tagline">Contact Us</span>
                    <h2 class="section-title__title">Get support for your problem</h2>
                    <p class=" section-title__text">Duis aute irure dolor in repreh enderit in volup tate velit esse
                        cillum dolore <br> eu fugiat nulla dolor atur with Lorem ipsum is simply </p>
                </div>
                <div class="contact-two__details-box">
                    <ul class="list-unstyled contact-two__details">
                        <li>
                            <div class="icon">
                                <span class="fa fa-envelope"></span>
                            </div>
                            <div class="content">
                                <span>Send us an email</span>
                                <p><a href="mailto:contact@gmail.com">contact@gmail.com</a></p>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <span class="fa fa-phone"></span>
                            </div>
                            <div class="content">
                                <span>Give us a call</span>
                                <p><a href="tel:0124357689">+012 (435) 7689</a></p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--Contact Two  End-->

    <!--Why Choose One Start-->
    <section class="why-choose-one">
        <div class="container">
            <div class="section-title section-title--two text-center">
                <span class="section-title__tagline">Why Choose Us</span>
                <h2 class="section-title__title">Gadget Repair For Everyone</h2>
                <p class="section-title__text">Duis aute irure dolor in repreh enderit in volup tate velit esse
                    cillum dolore <br> eu fugiat nulla dolor atur with Lorem ipsum is simply</p>
            </div>
            <div class="row">
                <div class="col-xl-6 col-lg-6 wow fadeInUp" data-wow-delay="100ms">
                    <!--Why Choose One Single Start-->
                    <div class="why-choose-one__single">
                        <div class="why-choose-one__icon">
                            <span class="icon-award"></span>
                        </div>
                        <div class="why-choose-one__content">
                            <h3 class="why-choose-one__title"><a href="services-details.html">Warranty Service</a>
                            </h3>
                            <p class="why-choose-one__text">Duis aute irure dolor in repreh enderit in
                                volup tate velit esse cillum dolore eu fugiat</p>
                        </div>
                    </div>
                    <!--Why Choose One Single Start-->
                </div>
                <div class="col-xl-6 col-lg-6 wow fadeInUp" data-wow-delay="200ms">
                    <!--Why Choose One Single Start-->
                    <div class="why-choose-one__single">
                        <div class="why-choose-one__icon">
                            <span class="icon-customer-service"></span>
                        </div>
                        <div class="why-choose-one__content">
                            <h3 class="why-choose-one__title"><a href="services-details.html">Customer Service</a>
                            </h3>
                            <p class="why-choose-one__text">Duis aute irure dolor in repreh enderit in
                                volup tate velit esse cillum dolore eu fugiat</p>
                        </div>
                    </div>
                    <!--Why Choose One Single Start-->
                </div>
                <div class="col-xl-6 col-lg-6 wow fadeInUp" data-wow-delay="300ms">
                    <!--Why Choose One Single Start-->
                    <div class="why-choose-one__single">
                        <div class="why-choose-one__icon">
                            <span class="icon-security"></span>
                        </div>
                        <div class="why-choose-one__content">
                            <h3 class="why-choose-one__title"><a href="services-details.html">Secured Device</a>
                            </h3>
                            <p class="why-choose-one__text">Duis aute irure dolor in repreh enderit in
                                volup tate velit esse cillum dolore eu fugiat</p>
                        </div>
                    </div>
                    <!--Why Choose One Single Start-->
                </div>
                <div class="col-xl-6 col-lg-6 wow fadeInUp" data-wow-delay="400ms">
                    <!--Why Choose One Single Start-->
                    <div class="why-choose-one__single">
                        <div class="why-choose-one__icon">
                            <span class="icon-computer-1"></span>
                        </div>
                        <div class="why-choose-one__content">
                            <h3 class="why-choose-one__title"><a href="services-details.html">No Virus Threat</a>
                            </h3>
                            <p class="why-choose-one__text">Duis aute irure dolor in repreh enderit in
                                volup tate velit esse cillum dolore eu fugiat</p>
                        </div>
                    </div>
                    <!--Why Choose One Single Start-->
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="why-choose-one__bottom">
                        <p class="why-choose-one__bottom-text">Get proper services from us <a href="about.html">guideline and
                                knowledge</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Why Choose One End-->

    <!--Two Section Start-->
    <section class="two-section">
        <div class="two-section-bg" style="background-image: url(assets/images/backgrounds/two-section-bg.jpg);">
        </div>
        <!--Skill Two Start-->
        <div class="skill-two">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="skill-one__left">
                            <div class="section-title text-left">
                                <span class="section-title__tagline">Our Skills & Expertise</span>
                                <h2 class="section-title__title">We Specialize In Quick &
                                    <br> Professional Repairs
                                </h2>
                            </div>
                            <p class="skill-one__text">There are many variations of passages of Lorem Ipsum
                                available,
                                but the majority have suffered alteration in some words which don't look even
                                slightly
                                believable.</p>
                            <p class="skill-one__text-2">There are many variations of passages of Lorem Ipsum
                                available,
                                but the majority have suffered alteration in some words which don't look even
                                slightly
                                believable.</p>
                            <div class="skill-one__progress">
                                <div class="skill-one__progress-single">
                                    <div class="bar">
                                        <div class="bar-inner count-bar" data-percent="84%">
                                            <div class="count-text">84%</div>
                                            <h4 class="skill-one__progress-title">Diagnostics</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="skill-one__progress-single">
                                    <div class="bar">
                                        <div class="bar-inner count-bar" data-percent="95%">
                                            <div class="count-text">95%</div>
                                            <h4 class="skill-one__progress-title">Replacment</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="skill-one__progress-single">
                                    <div class="bar marb-0">
                                        <div class="bar-inner count-bar" data-percent="86%">
                                            <div class="count-text">86%</div>
                                            <h4 class="skill-one__progress-title">Device Repair</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="skill-one__right">
                            <div class="skill-one__right-img-box wow slideInRight" data-wow-delay="100ms" data-wow-duration="2500ms">
                                <div class="skill-one__right-img">
                                    <img src="assets/images/resources/skill-1-1.jpg" alt="">
                                    <div class="skill-one__video-link">
                                        <a href="https://www.youtube.com/watch?v=Get7rqXYrbQ" class="video-popup">
                                            <div class="skill-one__video-icon">
                                                <span class="fa fa-play"></span>
                                                <i class="ripple"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="skill-one__video-content">
                                    <p>Improve gadget smartphone laptop repair services</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Skill Two End-->

        <!--Counter One Start-->
        <div class="counter-two">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <ul class="counter-two__list list-unstyled">
                            <li class="counter-two__single">
                                <h3 class="odometer" data-count="20">00</h3>
                                <span class="counter-two__plus">+</span>
                                <p class="counter-two__text">Glorious Years</p>
                            </li>
                            <li class="counter-two__single">
                                <h3 class="odometer" data-count="2">00</h3>
                                <span class="counter-two__plus">k+</span>
                                <p class="counter-two__text">Happy Customer</p>
                            </li>
                            <li class="counter-two__single">
                                <h3 class="odometer" data-count="5">00</h3>
                                <span class="counter-two__plus">k+</span>
                                <p class="counter-two__text">Service Complete</p>
                            </li>
                            <li class="counter-two__single">
                                <h3 class="odometer" data-count="99">00</h3>
                                <span class="counter-two__plus">%</span>
                                <p class="counter-two__text">Satisfactions</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--Counter One End-->

    </section>
    <!--Two Section End-->

    <!--Testimonial two Start-->
    <section class="testimonal-two">
        <div class="container">
            <div class="section-title section-title--two text-center">
                <span class="section-title__tagline">TESTIMONIAL</span>
                <h2 class="section-title__title">Our Customers Review</h2>
                <p class=" section-title__text">Duis aute irure dolor in repreh enderit in volup tate velit esse
                    cillum dolore <br> eu fugiat nulla dolor atur with Lorem ipsum is simply </p>
            </div>
            <div class="testimonial-two__carousel owl-carousel owl-theme thm-owl__carousel" data-owl-options='{
                    "loop": true,
                    "autoplay": true,
                    "margin": 30,
                    "nav": false,
                    "dots": true,
                    "smartSpeed": 500,
                    "autoplayTimeout": 10000,
                    "navText": ["<span class=\"icon-left-arrow\"></span>","<span class=\"icon-right-arrow1\"></span>"],
                    "responsive": {
                        "0": {
                            "items": 1
                        },
                        "768": {
                            "items": 2
                        },
                        "992": {
                            "items": 2
                        },
                        "1200": {
                            "items": 2
                        }
                    }
                }'>
                <!--Testimonial two Single Start-->
                <div class="item">
                    <div class="testimonial-two__sinlge">
                        <div class="testimonial-two__sinlge-inner">
                            <div class="testimonial-two__quote">
                                <span class="icon-quote"></span>
                            </div>
                            <p class="testimonial-two__text">Sed ut perspiciatis unde omnis iste natus rem eaque
                                ipsan quae ab illo inventore veritatis dolores eos qui voluptatem sequi nesciunt.
                            </p>
                            <div class="testimonial-two__info">
                                <div class="testimonial-two__client-img">
                                    <img src="assets/images/testimonial/testimonial-2-1.jpg" alt="">
                                </div>
                                <div class="testimonial-two__content">
                                    <h3 class="testimonial-two__client-name">Nicolas Marko</h3>
                                    <p class="testimonial-two__client-title">Graphic Designer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Testimonial two Single End-->
                <!--Testimonial two Single Start-->
                <div class="item">
                    <div class="testimonial-two__sinlge">
                        <div class="testimonial-two__sinlge-inner">
                            <div class="testimonial-two__quote">
                                <span class="icon-quote"></span>
                            </div>
                            <p class="testimonial-two__text">Sed ut perspiciatis unde omnis iste natus rem eaque
                                ipsan quae ab illo inventore veritatis dolores eos qui voluptatem sequi nesciunt.
                            </p>
                            <div class="testimonial-two__info">
                                <div class="testimonial-two__client-img">
                                    <img src="assets/images/testimonial/testimonial-2-2.jpg" alt="">
                                </div>
                                <div class="testimonial-two__content">
                                    <h3 class="testimonial-two__client-name">Jessica Smith</h3>
                                    <p class="testimonial-two__client-title">Graphic Designer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Testimonial two Single End-->
                <!--Testimonial two Single Start-->
                <div class="item">
                    <div class="testimonial-two__sinlge">
                        <div class="testimonial-two__sinlge-inner">
                            <div class="testimonial-two__quote">
                                <span class="icon-quote"></span>
                            </div>
                            <p class="testimonial-two__text">Sed ut perspiciatis unde omnis iste natus rem eaque
                                ipsan quae ab illo inventore veritatis dolores eos qui voluptatem sequi nesciunt.
                            </p>
                            <div class="testimonial-two__info">
                                <div class="testimonial-two__client-img">
                                    <img src="assets/images/testimonial/testimonial-2-1.jpg" alt="">
                                </div>
                                <div class="testimonial-two__content">
                                    <h3 class="testimonial-two__client-name">Nicolas Marko</h3>
                                    <p class="testimonial-two__client-title">Graphic Designer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Testimonial two Single End-->
                <!--Testimonial two Single Start-->
                <div class="item">
                    <div class="testimonial-two__sinlge">
                        <div class="testimonial-two__sinlge-inner">
                            <div class="testimonial-two__quote">
                                <span class="icon-quote"></span>
                            </div>
                            <p class="testimonial-two__text">Sed ut perspiciatis unde omnis iste natus rem eaque
                                ipsan quae ab illo inventore veritatis dolores eos qui voluptatem sequi nesciunt.
                            </p>
                            <div class="testimonial-two__info">
                                <div class="testimonial-two__client-img">
                                    <img src="assets/images/testimonial/testimonial-2-2.jpg" alt="">
                                </div>
                                <div class="testimonial-two__content">
                                    <h3 class="testimonial-two__client-name">Jessica Smith</h3>
                                    <p class="testimonial-two__client-title">Graphic Designer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Testimonial two Single End-->
                <!--Testimonial two Single Start-->
                <div class="item">
                    <div class="testimonial-two__sinlge">
                        <div class="testimonial-two__sinlge-inner">
                            <div class="testimonial-two__quote">
                                <span class="icon-quote"></span>
                            </div>
                            <p class="testimonial-two__text">Sed ut perspiciatis unde omnis iste natus rem eaque
                                ipsan quae ab illo inventore veritatis dolores eos qui voluptatem sequi nesciunt.
                            </p>
                            <div class="testimonial-two__info">
                                <div class="testimonial-two__client-img">
                                    <img src="assets/images/testimonial/testimonial-2-1.jpg" alt="">
                                </div>
                                <div class="testimonial-two__content">
                                    <h3 class="testimonial-two__client-name">Nicolas Marko</h3>
                                    <p class="testimonial-two__client-title">Graphic Designer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Testimonial two Single End-->
                <!--Testimonial two Single Start-->
                <div class="item">
                    <div class="testimonial-two__sinlge">
                        <div class="testimonial-two__sinlge-inner">
                            <div class="testimonial-two__quote">
                                <span class="icon-quote"></span>
                            </div>
                            <p class="testimonial-two__text">Sed ut perspiciatis unde omnis iste natus rem eaque
                                ipsan quae ab illo inventore veritatis dolores eos qui voluptatem sequi nesciunt.
                            </p>
                            <div class="testimonial-two__info">
                                <div class="testimonial-two__client-img">
                                    <img src="assets/images/testimonial/testimonial-2-2.jpg" alt="">
                                </div>
                                <div class="testimonial-two__content">
                                    <h3 class="testimonial-two__client-name">Jessica Smith</h3>
                                    <p class="testimonial-two__client-title">Graphic Designer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Testimonial two Single End-->
            </div>
        </div>
    </section>
    <!--Testimonial two End-->

    <!--Contact One Start-->
    <section class="contact-one contact-three">
        <div class="contact-one-bg jarallax" data-jarallax data-speed="0.2" data-imgPosition="50% 0%" style="background-image: url(assets/images/backgrounds/contact-three-bg.jpg);">
        </div>
        <div class="container">
            <div class="section-title section-title--two text-center">
                <span class="section-title__tagline">Contact Us</span>
                <h2 class="section-title__title">Let Us Know Or Call Us At</h2>
                <p class=" section-title__text">Duis aute irure dolor in repreh enderit in volup tate velit esse
                    cillum dolore <br> eu fugiat nulla dolor atur with Lorem ipsum is simply </p>
            </div>
            <div class="contact-one__form-box">
                <form action="assets/inc/sendemail.php" class="contact-one__form contact-form-validated" novalidate="novalidate">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4">
                            <div class="contact-form__input-box">
                                <input type="text" placeholder="Your Name" name="name">
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4">
                            <div class="contact-form__input-box">
                                <input type="email" placeholder="Email Address" name="email">
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4">
                            <div class="contact-form__input-box">
                                <input type="text" placeholder="Subject" name="Subject">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="contact-form__input-box text-message-box">
                                <textarea name="message" placeholder="Comment"></textarea>
                            </div>
                            <div class="contact-form__btn-box">
                                <button type="submit" class="thm-btn contact-form__btn">Send Message</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--Contact One End-->

    <!--Blog Two Start-->
    <section class="blog-two">
        <div class="container">
            <div class="section-title section-title--two text-center">
                <span class="section-title__tagline">From Our Blog</span>
                <h2 class="section-title__title">News And Articles</h2>
                <p class="section-title__text">Duis aute irure dolor in repreh enderit in volup tate velit esse
                    cillum dolore <br> eu fugiat nulla dolor atur with Lorem ipsum is simply </p>
            </div>
            <div class="row">
                <!--Blog Two Single Start-->
                <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="100ms">
                    <div class="blog-two__single">
                        <div class="blog-two__img">
                            <img src="assets/images/blog/blog-2-1.jpg" alt="">
                            <div class="blog-two__plus">
                                <a href="blog-details.html"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="blog-two__content">
                            <div class="blog-two__date">
                                <p>5 Aug 2023</p>
                            </div>
                            <h3 class="blog-two__title"><a href="blog-details.html">How To Fix Broken Back Glass On
                                    Your Phone</a></h3>
                            <p class="blog-two__text">Duis aute irure dolor in reprehenderit velit esse cillum
                                dolore eu fugiat nulla cupidatat non proident,</p>
                            <a href="blog-details.html" class="blog-two__read-more">Read More</a>
                        </div>
                    </div>
                </div>
                <!--Blog Two Single End-->
                <!--Blog Two Single Start-->
                <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="200ms">
                    <div class="blog-two__single">
                        <div class="blog-two__img">
                            <img src="assets/images/blog/blog-2-2.jpg" alt="">
                            <div class="blog-two__plus">
                                <a href="blog-details.html"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="blog-two__content">
                            <div class="blog-two__date">
                                <p>5 Aug 2023</p>
                            </div>
                            <h3 class="blog-two__title"><a href="blog-details.html">How To Fix Broken Screen On Your
                                    Laptop</a></h3>
                            <p class="blog-two__text">Duis aute irure dolor in reprehenderit velit esse cillum
                                dolore eu fugiat nulla cupidatat non proident,</p>
                            <a href="blog-details.html" class="blog-two__read-more">Read More</a>
                        </div>
                    </div>
                </div>
                <!--Blog Two Single End-->
                <!--Blog Two Single Start-->
                <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="300ms">
                    <div class="blog-two__single">
                        <div class="blog-two__img">
                            <img src="assets/images/blog/blog-2-3.jpg" alt="">
                            <div class="blog-two__plus">
                                <a href="blog-details.html"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="blog-two__content">
                            <div class="blog-two__date">
                                <p>5 Aug 2023</p>
                            </div>
                            <h3 class="blog-two__title"><a href="blog-details.html">What Is The Best Affordable
                                    Android Phone In 2023?</a></h3>
                            <p class="blog-two__text">Duis aute irure dolor in reprehenderit velit esse cillum
                                dolore eu fugiat nulla cupidatat non proident,</p>
                            <a href="blog-details.html" class="blog-two__read-more">Read More</a>
                        </div>
                    </div>
                </div>
                <!--Blog Two Single End-->
            </div>
        </div>
    </section>
    <!--Blog Two End-->

@endsection
