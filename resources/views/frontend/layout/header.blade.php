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

                    {{-- RIGHT : SEARCH (top) + MENU (bottom) --}}
                    <div class="main-menu-two__right">

                        {{-- SEARCH (top row) --}}
                        <div class="main-menu-two__search-cart-btn-box">
                            <div class="custom-header-search">
                                <input type="text" class="custom-header-search__input js-ajax-search-input" placeholder="Search products..." autocomplete="off">
                                <div class="custom-header-search__result js-ajax-search-result"></div>
                            </div>
                        </div>

                        {{-- MENU (bottom row) --}}
                        <div class="main-menu-two__main-menu-box">
                            <a href="#" class="mobile-nav__toggler">
                                <i class="fa fa-bars"></i>
                            </a>

                            <ul class="main-menu__list">
                                <li><a href="{{ route('index') }}">Home</a></li>

                                <li class="dropdown {{ request()->is('category/*') || request()->is('products') ? 'current' : '' }}">
                                    <a href="{{ route('products') }}">Products</a>

                                    <ul class="shadow-box custom-product-dropdown">
                                        @foreach ($header_categories as $cat)
                                            <li>
                                                <a href="{{ route('product.by.category', $cat->product_category_slug) }}" style="padding: 5px 20px 5px !important;">
                                                    {{ $cat->product_category_name }}
                                                </a>
                                            </li>
                                        @endforeach
                                        <li class="dropdown-divider-item">
                                            <hr>
                                        </li>
                                        <li>
                                            <a href="{{ route('products') }}" style="padding: 5px 20px 5px !important;">
                                                All Products
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li><a href="{{ route('frontend.battery') }}">Battery Items</a></li>
                                <li><a href="{{ route('flash.sale') }}">Excess Inventory</a></li>
                                <li><a href="{{ route('it.product') }}">IT Product</a></li>
                                <li><a href="{{ route('contact') }}">Contact</a></li>
                            </ul>
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
    /* ── Two-row right column ── */
    .main-menu-two__wrapper-inner {
        display: flex;
        align-items: flex-start;
        /* logo top-align korbe */
        gap: 24px;
    }

    .main-menu-two__left {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        padding-top: 6px;
    }

    .main-menu-two__right {
        flex: 1;
        display: flex;
        flex-direction: column;
        /* search upore, menu niche */
        gap: 0;
    }

    /* ── Search full width ── */
    .main-menu-two__search-cart-btn-box {
        width: 100%;
        padding: 10px 0 6px;
    }

    .custom-header-search {
        position: relative;
        width: 100%;
    }

    .custom-header-search__input {
        width: 100%;
        padding: 9px 16px 9px 16px;
        border: 1.5px solid #d1d5db;
        border-radius: 6px;
        background: #f9fafb;
        font-size: 14px;
        color: #111;
        outline: none;
        transition: border-color 0.2s, background 0.2s;
        box-sizing: border-box;
    }

    .custom-header-search__input:focus {
        border-color: #2563eb;
        background: #fff;
    }

    .custom-header-search__input::placeholder {
        color: #9ca3af;
    }

    .custom-header-search__result {
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.10);
        z-index: 1050;
    }

    /* ── Menu row ── */
    .main-menu-two__main-menu-box {
        width: 100%;
        padding: 0;
    }

    .main-menu-two__main-menu-box .main-menu__list {
        display: flex;
        flex-wrap: nowrap;
        gap: 0;
        padding: 0;
        margin: 0;
    }

    /* ── PRODUCT DROPDOWN ── */
    .custom-product-dropdown {
        min-width: 270px;
        padding: 12px !important;
        border-radius: 18px;
        border: 1px solid #f1f1f1;
        background: #fff;
    }

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

    .dropdown-divider-item {
        padding: 4px 8px !important;
    }

    .dropdown-divider-item hr {
        margin: 0;
        border-color: #eee;
    }

    .custom-product-dropdown li:last-child a {
        color: #555;
        font-weight: 600;
    }

    .custom-product-dropdown li:last-child a:hover {
        background: #f0f0f0;
        padding-left: 18px !important;
    }

    .main-menu .main-menu__list>li,
    .stricky-header .main-menu__list>li {
        padding-top: 0;
        padding-bottom: 15px;
        position: relative;
    }

    .main-menu-two__search-cart-btn-box {
        padding: 22.5px 0;
        margin-left: 0;
    }

    .main-menu-two__wrapper-inner {
        align-items: center;
    }
</style>
