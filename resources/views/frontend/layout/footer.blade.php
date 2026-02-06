<footer class="site-footer site-footer-two">

    <div class="site-footer-shape-1 float-bob-y-2" style="background-image: url({{ asset('frontend/assets/images/shapes/site-footer-shape-1.png') }});"></div>

    <div class="site-footer__top">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                    <div class="footer-widget__column footer-widget__about">
                        <div class="footer-widget__logo">
                            <a href="{{ route('index') }}"><img src="{{ asset('frontend/assets/images/resources/footer-logo-2.png') }}" alt=""></a>
                        </div>
                        <div class="footer-widget__about-text-box">
                            <p class="footer-widget__about-text">Duis aute irure dolor in reprehenderit in
                                voluptate velit esse cillum dolore fugiat nulla pariatur.</p>
                        </div>
                        <div class="footer-widget__social-box">
                            <h4 class="footer-widget__social-title">Stay Connected</h4>
                            <div class="site-footer__social">
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-facebook"></i></a>
                                <a href="#"><i class="fab fa-pinterest-p"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
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
                            <li><a href="index.html">Home</a></li>
                            <li><a href="about.html">About Us</a></li>
                            <li><a href="services.html">Services</a></li>
                            <li><a href="blog-v-1.html">Blog</a></li>
                            <li><a href="contact.html">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                    <div class="footer-widget__column footer-widget__services">
                        <div class="footer-widget__title-box">
                            <h3 class="footer-widget__title">Our Services</h3>
                        </div>
                        <ul class="footer-widget__services-list list-unstyled">
                            <li><a href="services-details.html">Smartphone Repair</a></li>
                            <li><a href="services-details.html">Laptop Repair</a></li>
                            <li><a href="services-details.html">Desktop Repair</a></li>
                            <li><a href="services-details.html">Tablet Repair</a></li>
                            <li><a href="services-details.html">Smart Watch Repair</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="400ms">
                    <div class="footer-widget__column footer-widget__subscribe">
                        <div class="footer-widget__title-box">
                            <h3 class="footer-widget__title">Subscribe</h3>
                        </div>
                        <form class="footer-widget__subscribe-box">
                            <div class="footer-widget__subscribe-input-box">
                                <input type="email" placeholder="Your Email" name="email">
                                <button type="submit" class="footer-widget__subscribe-btn thm-btn">Subscribe
                                    Now</button>
                            </div>
                        </form>
                        <p class="footer-widget__subscribe-text">Stay always in touch! Subscribe to our
                            newsletter.</p>
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
