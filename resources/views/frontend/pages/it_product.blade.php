@extends('frontend.dashboard')
@section('frontend_title', 'IT Product')
@section('frontend_contents')

    {{-- Breadcrumb --}}
    <section class="page-header">
        <div class="page-header-bg" style="background-image: url({{ asset('frontend/assets/static_images/breadcrumb.jpg') }})"></div>
        <div class="container">
            <div class="page-header__inner">
                <h2>IT Product</h2>
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><span>//</span></li>
                    <li>IT Product</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Product Area --}}
    <section class="product">
        <div class="container">
            <div class="row">

                {{-- ===== SIDEBAR ===== --}}
                <div class="col-xl-3 col-lg-3">
                    <div class="product__sidebar">

                        {{-- IT Categories --}}
                        @if ($it_category_data->count() > 0)
                            <div class="shop-category product__sidebar-single">
                                <h3 class="product__sidebar-title">Categories</h3>
                                @foreach ($it_category_data as $itCat)
                                    <label class="filter-check">
                                        <input type="checkbox" class="js-filter-it-category" value="{{ $itCat->id }}" {{ in_array($itCat->id, (array) request('it_categories')) ? 'checked' : '' }}>
                                        {{ $itCat->name }}
                                    </label>
                                @endforeach
                            </div>
                        @endif

                        {{-- Brands --}}
                        <div class="shop-category product__sidebar-single">
                            <h3 class="product__sidebar-title">Brands</h3>
                            @foreach ($product_brand_data as $brand)
                                <label class="filter-check">
                                    <input type="checkbox" class="js-filter-brand" value="{{ $brand->id }}" {{ in_array($brand->id, (array) request('brands')) ? 'checked' : '' }}>
                                    {{ $brand->product_brand_name }}
                                </label>
                            @endforeach
                        </div>

                    </div>
                </div>

                {{-- ===== PRODUCT AREA ===== --}}
                <div class="col-xl-9 col-lg-9">

                    {{-- Search Bar --}}
                    <div class="shop-search product__sidebar-single product__price-ranger">
                        <div class="custom-sidebar-search js-sidebar-search">
                            <input type="text" id="it-search-input" class="custom-sidebar-search__input" placeholder="Search IT products..." autocomplete="off" value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="product__items">

                        {{-- Showing result --}}
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="product__showing-result d-flex justify-content-between align-items-center">
                                    <a href="{{ route('it.product') }}" id="clear-all-filters" style="{{ request()->hasAny(['brands', 'search', 'it_categories']) ? '' : 'display:none;' }} color:red; text-decoration:underline;">
                                        Clear All
                                    </a>
                                    <div class="product__showing-text-box">
                                        <p class="product__showing-text" id="product-showing-text">
                                            Showing {{ $product_data->firstItem() ?? 0 }}–{{ $product_data->lastItem() ?? 0 }}
                                            of {{ $product_data->total() }} results
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product__all" id="product-list-wrapper">
                            <div class="row" id="product-grid">
                                @forelse ($product_data as $item)
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 custom_product_margin">
                                        <div class="product__all-single h-100 d-flex flex-column">
                                            <a href="{{ route('product.details', $item->product_slug) }}">
                                                <div class="product__all-img">
                                                    <img src="{{ asset($item->product_image) }}" alt="">
                                                </div>
                                            </a>
                                            <div class="product__all-content mt-auto">
                                                <span class="product__category">
                                                    <a href="{{ route('product.by.brand', $item->brand->product_brand_slug ?? '#!') }}">{{ $item->brand->product_brand_name ?? 'Uncategorized' }}</a>
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
                                        <p>No products found.</p>
                                    </div>
                                @endforelse
                            </div>

                            {{-- Pagination --}}
                            @if ($product_data->hasPages())
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="blog-page__pagination">
                                            <ul class="pg-pagination list-unstyled">

                                                @if (!$product_data->onFirstPage())
                                                    <li class="prev">
                                                        <a href="{{ $product_data->previousPageUrl() }}" aria-label="Previous">
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
                                                        <a href="{{ $product_data->nextPageUrl() }}" aria-label="Next">
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

    <script>
        (function() {
            function applyFilters() {
                const brands = [...document.querySelectorAll('.js-filter-brand:checked')].map(el => el.value);
                const itCategories = [...document.querySelectorAll('.js-filter-it-category:checked')].map(el => el.value);
                const search = document.getElementById('it-search-input')?.value.trim() ?? '';

                const params = new URLSearchParams();
                brands.forEach(v => params.append('brands[]', v));
                itCategories.forEach(v => params.append('it_categories[]', v));
                if (search) params.set('search', search);

                window.location.href = '{{ route('it.product') }}?' + params.toString();
            }

            document.querySelectorAll('.js-filter-brand, .js-filter-it-category').forEach(function(checkbox) {
                checkbox.addEventListener('change', applyFilters);
            });

            let searchTimer;
            const searchInput = document.getElementById('it-search-input');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimer);
                    searchTimer = setTimeout(applyFilters, 500);
                });
            }

            // ✅ Clear All Fix
            const clearBtn = document.getElementById('clear-all-filters');
            if (clearBtn) {
                clearBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Uncheck all checkboxes
                    document.querySelectorAll('.js-filter-brand, .js-filter-it-category').forEach(function(cb) {
                        cb.checked = false;
                    });

                    // Clear search input
                    const searchInput = document.getElementById('it-search-input');
                    if (searchInput) searchInput.value = '';

                    // Redirect to clean URL
                    window.location.href = '{{ route('it.product') }}';
                });
            }
        })();
    </script>

@endsection
