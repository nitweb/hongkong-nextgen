<header class="main-header-two">

    <nav class="main-menu main-menu-two">

        <div class="main-menu-two__wrapper">

            <div class="container">

                <div class="main-menu-two__wrapper-inner">

                    <div class="main-menu-two__left">
                        <div class="main-menu-two__logo">
                            <a href="{{ route('index') }}"><img src="{{ asset(GlobalSiteSettings()->site_header_logo) }}" alt=""></a>
                        </div>
                    </div>

                    <div class="main-menu-two__right">

                        <div class="main-menu-two__main-menu-box">

                            <a href="#" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>

                            <ul class="main-menu__list">

                                <li><a href="{{ route('index') }}">Home</a></li>

                                <li class="dropdown">
                                    <a href="{{ route('products') }}">Products</a>
                                    <ul class="shadow-box">
                                        <li><a href="#!">Category</a></li>
                                        <li><a href="#!">Category</a></li>
                                        <li><a href="#!">Category</a></li>
                                        <li><a href="#!">Category</a></li>
                                    </ul>
                                </li>

                                <li><a href="#!">Gallery</a></li>

                                <li><a href="{{ route('blog') }}">Blog</a></li>

                                <li><a href="{{ route('contact') }}">Contact</a></li>

                            </ul>

                        </div>

                        <div class="main-menu-two__search-cart-btn-box">

                            <div class="main-menu-two__search-box">
                                <a href="#" class="main-menu-two__search search-toggler icon-search-interface-symbol"></a>
                            </div>

                            {{-- <div class="main-menu-two__btn-box">
                                <a href="appointment.html" class="thm-btn main-menu-two__btn">Book A Service</a>
                            </div> --}}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </nav>

</header>


{{-- Sticky Header --}}
<div class="stricky-header stricked-menu main-menu main-menu-two">
    <div class="sticky-header__content"></div>
</div>
