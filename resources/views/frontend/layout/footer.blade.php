<footer class="site-footer site-footer-two">

    <div class="site-footer-shape-1 float-bob-y-2" style="background-image: url({{ asset('frontend/assets/images/shapes/site-footer-shape-1.png') }});"></div>

    <div class="site-footer__top">

        <div class="container">

            <div class="row">

                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                    <div class="footer-widget__column footer-widget__about">
                        <div class="footer-widget__logo">
                            <a href="{{ route('index') }}"><img src="{{ asset(GlobalSiteSettings()->site_footer_logo) }}" alt=""></a>
                        </div>
                        <div class="footer-widget__about-text-box">
                            <p class="footer-widget__about-text">
                                {{ GlobalSiteSettings()->site_description ?? '' }}
                            </p>
                        </div>
                        <div class="footer-widget__social-box">
                            <h4 class="footer-widget__social-title">Stay Connected</h4>
                            <div class="site-footer__social">
                                <a href="#!"><i class="fab fa-twitter"></i></a>
                                <a href="#!"><i class="fab fa-facebook"></i></a>
                                <a href="#!"><i class="fab fa-pinterest-p"></i></a>
                                <a href="#!"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                    <div class="footer-widget__column footer-widget__links">
                        <div class="footer-widget__title-box">
                            <h3 class="footer-widget__title">Quick Links</h3>
                        </div>
                        <ul class="footer-widget__Explore-list list-unstyled">
                            {{-- <li><a href="{{ route('index') }}">Home</a></li> --}}
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('blog') }}">Blog</a></li>
                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                            <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('terms.conditions') }}">Terms & Conditions</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                    <div class="footer-widget__column footer-widget__services">
                        <div class="footer-widget__title-box">
                            <h3 class="footer-widget__title">Our Brands</h3>
                        </div>
                        <ul class="footer-widget__services-list list-unstyled">
                            @foreach ($product_brands as $item)
                                <li><a href="{{ route('product.by.brand', $item->product_brand_slug) }}">{{ $item->product_brand_name }}</a></li>
                            @endforeach
                            {{-- <li><a href="services-details.html">Smartphone Repair</a></li> --}}
                        </ul>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="400ms">
                    <div class="footer-widget__column footer-widget__subscribe">
                        <div class="footer-widget__title-box">
                            <h3 class="footer-widget__title">Contact Information</h3>
                        </div>
                        <p class="footer-widget__subscribe-text" style="padding-top: 0px;">
                            <strong>Address:</strong> {!! GlobalSiteSettings()->site_address !!}
                        </p>
                        <p class="footer-widget__subscribe-text">
                            <strong>Email:</strong> <a href="mailto:{{ GlobalSiteSettings()->site_email }}" target="_blank" style="color: #fff">{{ GlobalSiteSettings()->site_email }}</a>
                        </p>
                        <p class="footer-widget__subscribe-text">
                            <span>Phone:</span> <a href="tel:{{ GlobalSiteSettings()->site_phone }}" target="_blank" style="color: #fff">{{ GlobalSiteSettings()->site_phone }}</a>
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="site-footer__bottom">
        <div class="container">
            <div class="site-footer__bottom-inner">
                <p class="site-footer__bottom-text">
                    Copyright © 2026 <a href="{{ route('index') }}">Semiconductor</a>. Developed by <a href="https://web.nebulaitbd.com/" target="_blank">Nebula IT</a>.
                </p>
            </div>
        </div>
    </div>

</footer>
