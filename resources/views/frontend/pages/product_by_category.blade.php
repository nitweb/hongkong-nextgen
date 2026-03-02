@extends('frontend.dashboard')
@section('frontend_title', $category->product_category_name ?? 'Products')

@section('frontend_contents')

    {{-- ================= Breadcrumb ================= --}}
    <section class="page-header">
        <div class="page-header-bg" style="background-image: url({{ asset('frontend/assets/static_images/breadcrumb.jpg') }})"></div>
        <div class="container">
            <div class="page-header__inner">
                <h2>{{ $category->product_category_name ?? 'Products' }}</h2>
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><span>//</span></li>
                    <li><a href="{{ route('products') }}">Product</a></li>
                    <li><span>//</span></li>
                    <li>{{ $category->product_category_name ?? 'Category' }}</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- ================= Product Area ================= --}}
    <section class="product">
        <div class="container">
            <div class="row">

                {{-- Sidebar --}}
                <div class="col-xl-3 col-lg-3">
                    <div class="product__sidebar">

                        <div class="shop-category product__sidebar-single">
                            <h3 class="product__sidebar-title">Categories</h3>
                            @foreach ($category_data as $cat)
                                <label class="filter-check">
                                    <input type="checkbox" class="js-filter-category" value="{{ $cat->id }}" {{ ($category && $cat->id == $category->id) || in_array($cat->id, (array) request('categories')) ? 'checked' : '' }}>
                                    {{ $cat->product_category_name }} ({{ $cat->products_count }})
                                </label>
                            @endforeach
                        </div>

                        <div class="shop-category product__sidebar-single">
                            <h3 class="product__sidebar-title">Brands</h3>
                            @foreach ($product_brand_data as $brand)
                                <label class="filter-check">
                                    <input type="checkbox" class="js-filter-brand" value="{{ $brand->id }}" {{ (isset($brand_info) && $brand->id == $brand_info->id) || in_array($brand->id, (array) request('brands')) ? 'checked' : '' }}>
                                    {{ $brand->product_brand_name }} ({{ $brand->products_count }})
                                </label>
                            @endforeach

                        </div>

                    </div>
                </div>

                {{-- Products --}}
                <div class="col-xl-9 col-lg-9">

                    {{-- Search Product --}}
                    <div class="shop-search product__sidebar-single product__price-ranger">
                        <div class="custom-sidebar-search js-sidebar-search">
                            <input type="text" class="custom-sidebar-search__input js-ajax-search-input" placeholder="Search products..." autocomplete="off">
                            <div class="custom-sidebar-search__result js-ajax-search-result"></div>
                        </div>
                    </div>

                    <div class="product__items">

                        {{-- Showing result --}}
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="product__showing-result d-flex justify-content-between align-items-center">

                                    <!-- Clear All Link (Left) - Initially Hidden -->
                                    <a href="#!" id="clear-all-filters" style="display: none; color: red; text-decoration: underline;">Clear All</a>

                                    <!-- Empty div to balance flex layout when "Clear All" is hidden -->
                                    <div id="clear-all-placeholder" style="visibility: hidden; flex: 0 0 auto; color: red; text-decoration: underline;">Clear All</div>

                                    <!-- Showing Results (Right) -->
                                    <div class="product__showing-text-box">
                                        <p class="product__showing-text" id="product-showing-text">
                                            Showing {{ $product_data->firstItem() ?? 0 }}–{{ $product_data->lastItem() ?? 0 }}
                                            of {{ $product_data->total() }} results
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Product list --}}
                        <div class="product__all" id="product-list-wrapper">
                            <div class="row" id="product-grid">
                                @forelse ($product_data as $item)
                                    <div class="col-xl-4 col-lg-4 col-md-6 custom_product_margin">
                                        <div class="product__all-single">
                                            <a href="{{ route('product.details', $item->product_slug) }}">
                                                <div class="product__all-img">
                                                    <img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}">
                                                </div>
                                            </a>
                                            <div class="product__all-content">
                                                <span class="product__category">
                                                    <a href="{{ route('product.by.category', $item->category->product_category_slug ?? '#') }}">{{ $item->category->product_category_name ?? 'Uncategorized' }}</a>
                                                </span>
                                                <h4 class="product__all-title">
                                                    <a href="{{ route('product.details', $item->product_slug) }}">
                                                        {{ Str::limit($item->product_name, 40) }}
                                                    </a>
                                                </h4>
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
                                <div class="blog-page__pagination">
                                    <ul class="pg-pagination list-unstyled">
                                        @if (!$product_data->onFirstPage())
                                            <li class="prev">
                                                <a href="{{ $product_data->previousPageUrl() }}">
                                                    <i class="fa fa-angle-double-left"></i>
                                                </a>
                                            </li>
                                        @endif
                                        @foreach ($product_data->getUrlRange(1, $product_data->lastPage()) as $page => $url)
                                            <li class="count {{ $page == $product_data->currentPage() ? 'active' : '' }}">
                                                <a href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endforeach
                                        @if ($product_data->hasMorePages())
                                            <li class="next">
                                                <a href="{{ $product_data->nextPageUrl() }}">
                                                    <i class="fa fa-angle-double-right"></i>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
