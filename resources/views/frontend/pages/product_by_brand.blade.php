@extends('frontend.dashboard')
@section('frontend_title', $brand_info->product_brand_name ?? 'Products')

@section('frontend_contents')

    {{-- ================= Breadcrumb ================= --}}
    <section class="page-header">
        <div class="page-header-bg" style="background-image: url({{ asset('frontend/assets/static_images/breadcrumb.jpg') }})">
        </div>

        <div class="container">
            <div class="page-header__inner">
                <h2>{{ $brand_info->product_brand_name ?? 'Products' }}</h2>
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><span>//</span></li>
                    <li><a href="{{ route('products') }}">Product</a></li>
                    <li><span>//</span></li>
                    <li>Brand</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- ================= Product Area ================= --}}
    <section class="product">
        <div class="container">
            <div class="row">

                {{-- ========== Sidebar ========== --}}
                <div class="col-xl-3 col-lg-3">
                    <div class="product__sidebar">

                        {{-- Search Product --}}
                        <div class="shop-search product__sidebar-single product__price-ranger">

                            <div class="custom-sidebar-search js-sidebar-search">

                                <input type="text" class="custom-sidebar-search__input js-ajax-search-input" placeholder="Search products..." autocomplete="off">

                                <div class="custom-sidebar-search__result js-ajax-search-result"></div>

                            </div>

                        </div>

                        {{-- Price Filter (UI only) --}}
                        <div class="product__price-ranger product__sidebar-single">
                            <h3 class="product__sidebar-title">Price</h3>
                            <div class="custom-price-filter js-price-filter" data-min="{{ request('min_price') }}" data-max="{{ request('max_price') }}">
                                <div class="custom-price-filter__slider" id="priceRangeSlider"></div>
                                <div class="custom-price-filter__inputs">
                                    <input type="text" class="price-min js-price-min" readonly>
                                    <span>-</span>
                                    <input type="text" class="price-max js-price-max" readonly>
                                </div>
                            </div>
                        </div>

                        {{-- Categories --}}
                        <div class="shop-category product__sidebar-single">
                            <h3 class="product__sidebar-title">Categories</h3>

                            <ul class="list-unstyled">
                                @foreach ($category_data as $cat)
                                    <li class="{{ request()->route('slug') == $cat->product_category_slug ? 'active' : '' }}">
                                        <a href="{{ route('product.by.category', $cat->product_category_slug) }}">
                                            {{ $cat->product_category_name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Brands --}}
                        <div class="shop-category product__sidebar-single">
                            <h3 class="product__sidebar-title">Brands</h3>
                            <ul class="list-unstyled">
                                @foreach ($product_brand_data as $item)
                                    <li class="{{ request()->route('slug') == $item->product_brand_slug ? 'active' : '' }}">
                                        <a href="{{ route('product.by.brand', $item->product_brand_slug) }}">
                                            {{ $item->product_brand_name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>

                {{-- ========== Products ========== --}}
                <div class="col-xl-9 col-lg-9">
                    <div class="product__items">

                        {{-- Showing Result --}}
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="product__showing-result">
                                    <div class="product__showing-text-box">
                                        <p class="product__showing-text" id="product-showing-text">
                                            Showing
                                            {{ $product_data->firstItem() ?? 0 }}
                                            –
                                            {{ $product_data->lastItem() ?? 0 }}
                                            of
                                            {{ $product_data->total() }}
                                            results
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Product List --}}
                        <div class="product__all" id="product-list-wrapper">
                            <div class="row">

                                @forelse ($product_data as $item)
                                    <div class="col-xl-4 col-lg-4 col-md-6">
                                        <div class="product__all-single">

                                            <a href="{{ route('product.details', $item->product_slug) }}">
                                                <div class="product__all-img">
                                                    <img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}">
                                                </div>
                                            </a>

                                            <div class="product__all-content">

                                                <span class="product__category">
                                                    {{ $item->category->product_category_name ?? 'Uncategorized' }}
                                                </span>

                                                <h4 class="product__all-title">
                                                    <a href="{{ route('product.details', $item->product_slug) }}">
                                                        {{ Str::limit($item->product_name, 40) }}
                                                    </a>
                                                </h4>

                                                <p class="product__all-price mt-2">
                                                    <span class="new__price">
                                                        $
                                                        {{ number_format($item->product_price - ($item->discount_price ?? 0), 2) }}
                                                    </span>

                                                    @if (!empty($item->discount_price) && $item->discount_price > 0)
                                                        <span class="old__price">
                                                            ${{ number_format($item->product_price, 2) }}
                                                        </span>
                                                    @endif
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-xl-12">
                                        <p class="text-center">No products found.</p>
                                    </div>
                                @endforelse

                            </div>

                            {{-- Pagination --}}
                            @if ($product_data->hasPages())
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="blog-page__pagination">
                                            <ul class="pg-pagination list-unstyled">

                                                {{-- Prev --}}
                                                @if (!$product_data->onFirstPage())
                                                    <li class="prev">
                                                        <a href="{{ $product_data->previousPageUrl() }}">
                                                            <i class="fa fa-angle-double-left"></i>
                                                        </a>
                                                    </li>
                                                @endif

                                                {{-- Pages --}}
                                                @foreach ($product_data->getUrlRange(1, $product_data->lastPage()) as $page => $url)
                                                    <li class="count {{ $page == $product_data->currentPage() ? 'active' : '' }}">
                                                        <a href="{{ $url }}">{{ $page }}</a>
                                                    </li>
                                                @endforeach

                                                {{-- Next --}}
                                                @if ($product_data->hasMorePages())
                                                    <li class="next">
                                                        <a href="{{ $product_data->nextPageUrl() }}">
                                                            <i class="fa fa-angle-double-right"></i>
                                                        </a>
                                                    </li>
                                                @endif

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
