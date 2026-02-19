<header class="main-header-two">

    <nav class="main-menu main-menu-two">
        <div class="main-menu-two__wrapper">
            <div class="container">
                <div class="main-menu-two__wrapper-inner">

                    {{-- LEFT : LOGO --}}
                    <div class="main-menu-two__left">
                        <div class="main-menu-two__logo">
                            <a href="{{ route('index') }}">
                                <img src="{{ asset(GlobalSiteSettings()->site_header_logo) }}" alt="Logo">
                            </a>
                        </div>
                    </div>

                    {{-- RIGHT : MENU + SEARCH --}}
                    <div class="main-menu-two__right">

                        {{-- MENU --}}
                        <div class="main-menu-two__main-menu-box">
                            <a href="#" class="mobile-nav__toggler">
                                <i class="fa fa-bars"></i>
                            </a>

                            <ul class="main-menu__list">
                                <li><a href="{{ route('index') }}">Home</a></li>

                                <li class="dropdown {{ request()->is('category/*') ? 'current' : '' }}">
                                    <a href="{{ route('products') }}">Products</a>
                                    <ul class="shadow-box">
                                        @foreach ($header_categories as $cat)
                                            <li>
                                                <a href="{{ route('product.by.category', $cat->product_category_slug) }}">
                                                    {{ $cat->product_category_name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>

                                <li><a href="{{ route('flash.sale') }}">Flash Sale</a></li>
                                <li><a href="{{ route('it.product') }}">IT Product</a></li>
                                <li><a href="{{ route('contact') }}">Contact</a></li>
                            </ul>
                        </div>

                        {{-- SEARCH --}}
                        <div class="main-menu-two__search-cart-btn-box">
                            <div class="custom-header-search">
                                <input type="text" class="custom-header-search__input js-ajax-search-input" placeholder="Search products..." autocomplete="off">

                                <div class="custom-header-search__result js-ajax-search-result"></div>
                            </div>

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
