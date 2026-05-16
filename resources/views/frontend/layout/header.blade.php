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
                                <li><a href="{{ route('about') }}">About Us</a></li>

                                <li class="dropdown {{ request()->is('category/*') || request()->is('products') ? 'current' : '' }}">
                                    <a href="{{ route('products') }}">Products</a>

                                    <ul class="shadow-box custom-product-dropdown">

                                        {{-- CATEGORY LIST --}}
                                        @foreach ($header_categories as $cat)
                                            <li>
                                                <a href="{{ route('product.by.category', $cat->product_category_slug) }}" style="padding: 5px 20px 5px !important;">
                                                    {{ $cat->product_category_name }}
                                                </a>
                                            </li>
                                        @endforeach

                                        {{-- DIVIDER --}}
                                        <li class="dropdown-divider-item">
                                            <hr>
                                        </li>

                                        {{-- ALL PRODUCTS --}}
                                        <li>
                                            <a href="{{ route('products') }}" style="padding: 5px 20px 5px !important;">
                                                All Products
                                            </a>
                                        </li>

                                    </ul>
                                </li>

                                <li><a href="{{ route('flash.sale') }}">Excess Inventory</a></li>
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


<style>
    /* PRODUCT DROPDOWN */
    .custom-product-dropdown {
        min-width: 270px;
        padding: 12px !important;
        border-radius: 18px;
        border: 1px solid #f1f1f1;
        background: #fff;
    }

    /* CATEGORY ITEMS */
    .custom-product-dropdown li a {
        display: block;
        padding: 11px 14px !important;
        border-radius: 10px;
        transition: all 0.25s ease;
        color: #333;
    }

    .custom-product-dropdown li a:hover {
        background: #f7f7f7;
        padding-left: 18px !important;
    }

    /* DIVIDER */
    .dropdown-divider-item {
        padding: 4px 8px !important;
    }

    .dropdown-divider-item hr {
        margin: 0;
        border-color: #eee;
    }

    /* ALL PRODUCTS (last item) */
    .custom-product-dropdown li:last-child a {
        color: #555;
        font-weight: 600;
    }

    .custom-product-dropdown li:last-child a:hover {
        background: #f0f0f0;
        padding-left: 18px !important;
    }
</style>
