<footer class="site-footer site-footer-two">

    <div class="site-footer-shape-1 float-bob-y-2" style="background-image: url({{ asset('frontend/assets/images/shapes/site-footer-shape-1.png') }});"></div>

    <div class="site-footer__top">
        <div class="container">
            <div class="row">

                {{-- About / Logo --}}
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                    <div class="footer-widget__column footer-widget__about">
                        <div class="footer-widget__logo">
                            <a href="{{ route('index') }}">
                                <img src="{{ asset(GlobalSiteSettings()->site_footer_logo) }}" alt="">
                            </a>
                        </div>
                        <div class="footer-widget__about-text-box">
                            <p class="footer-widget__about-text">
                                {!! GlobalSiteSettings()->site_description ?? '' !!}
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

                {{-- Quick Links --}}
                <div class="col-xl-2 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                    <div class="footer-widget__column footer-widget__links">
                        <div class="footer-widget__title-box">
                            <h3 class="footer-widget__title">Quick Links</h3>
                        </div>
                        <ul class="footer-widget__Explore-list list-unstyled">
                            <li><a href="{{ route('index') }}">Home</a></li>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('products') }}">Products</a></li>
                            <li><a href="{{ route('flash.sale') }}">Excess Inventory</a></li>
                            <li><a href="{{ route('blog') }}">Blog</a></li>
                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                            <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('terms.conditions') }}">Terms & Conditions</a></li>
                        </ul>
                    </div>
                </div>

                {{-- Our Brands --}}
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                    <div class="footer-widget__column footer-widget__services">
                        <div class="footer-widget__title-box">
                            <h3 class="footer-widget__title">Our Brands</h3>
                        </div>
                        <ul class="footer-widget__services-list list-unstyled">
                            @foreach ($product_brands as $item)
                                <li>
                                    <a href="{{ route('product.by.brand', $item->product_brand_slug) }}">
                                        {{ $item->product_brand_name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Contact Information --}}
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="400ms">
                    <div class="footer-widget__column footer-widget__subscribe">
                        <div class="footer-widget__title-box">
                            <h3 class="footer-widget__title">Contact Information</h3>
                        </div>

                        <ul class="footer-widget__contact-list">

                            {{-- Address --}}
                            <li>
                                <div class="footer-contact__icon">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1 1 18 0z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                </div>
                                <div class="footer-contact__body">
                                    <span class="footer-contact__label">Address</span>
                                    <p class="footer-contact__value">{!! GlobalSiteSettings()->site_address !!}</p>
                                </div>
                            </li>

                            <li>
                                <div class="footer-contact__divider"></div>
                            </li>

                            {{-- Person 1 --}}
                            @if (GlobalSiteSettings()->person1_name)
                                <li>
                                    <div class="footer-contact__icon">
                                        <svg viewBox="0 0 24 24">
                                            <rect x="2" y="4" width="20" height="16" rx="2" />
                                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                        </svg>
                                    </div>
                                    <div class="footer-contact__body">
                                        <span class="footer-contact__label">{{ GlobalSiteSettings()->person1_name }}</span>
                                        @if (GlobalSiteSettings()->person1_email)
                                            <p class="footer-contact__value">
                                                <a href="mailto:{{ GlobalSiteSettings()->person1_email }}" target="_blank">
                                                    {{ GlobalSiteSettings()->person1_email }}
                                                </a>
                                            </p>
                                        @endif
                                        @if (GlobalSiteSettings()->person1_phone)
                                            <p class="footer-contact__value">
                                                <a href="tel:{{ GlobalSiteSettings()->person1_phone }}" target="_blank">
                                                    {{ GlobalSiteSettings()->person1_phone }}
                                                </a>
                                            </p>
                                        @endif
                                    </div>
                                </li>
                            @endif

                            {{-- Person 2 --}}
                            @if (GlobalSiteSettings()->person2_name)
                                <li>
                                    <div class="footer-contact__icon">
                                        <svg viewBox="0 0 24 24">
                                            <rect x="2" y="4" width="20" height="16" rx="2" />
                                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                        </svg>
                                    </div>
                                    <div class="footer-contact__body">
                                        <span class="footer-contact__label">{{ GlobalSiteSettings()->person2_name }}</span>
                                        @if (GlobalSiteSettings()->person2_email)
                                            <p class="footer-contact__value">
                                                <a href="mailto:{{ GlobalSiteSettings()->person2_email }}" target="_blank">
                                                    {{ GlobalSiteSettings()->person2_email }}
                                                </a>
                                            </p>
                                        @endif
                                        @if (GlobalSiteSettings()->person2_phone)
                                            <p class="footer-contact__value">
                                                <a href="tel:{{ GlobalSiteSettings()->person2_phone }}" target="_blank">
                                                    {{ GlobalSiteSettings()->person2_phone }}
                                                </a>
                                            </p>
                                        @endif
                                    </div>
                                </li>
                            @endif

                            {{-- Person 3 --}}
                            @if (GlobalSiteSettings()->person3_name)
                                <li>
                                    <div class="footer-contact__icon">
                                        <svg viewBox="0 0 24 24">
                                            <rect x="2" y="4" width="20" height="16" rx="2" />
                                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                        </svg>
                                    </div>
                                    <div class="footer-contact__body">
                                        <span class="footer-contact__label">{{ GlobalSiteSettings()->person3_name }}</span>
                                        @if (GlobalSiteSettings()->person3_email)
                                            <p class="footer-contact__value">
                                                <a href="mailto:{{ GlobalSiteSettings()->person3_email }}" target="_blank">
                                                    {{ GlobalSiteSettings()->person3_email }}
                                                </a>
                                            </p>
                                        @endif
                                        @if (GlobalSiteSettings()->person3_phone)
                                            <p class="footer-contact__value">
                                                <a href="tel:{{ GlobalSiteSettings()->person3_phone }}" target="_blank">
                                                    {{ GlobalSiteSettings()->person3_phone }}
                                                </a>
                                            </p>
                                        @endif
                                    </div>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="site-footer__bottom">
        <div class="container">
            <div class="site-footer__bottom-inner">
                <p class="site-footer__bottom-text">
                    {!! GlobalSiteSettings()->site_copyright !!}
                </p>
            </div>
        </div>
    </div>

</footer>
