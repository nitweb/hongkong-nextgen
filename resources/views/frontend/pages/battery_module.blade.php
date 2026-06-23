@extends('frontend.dashboard')
@section('frontend_title', 'Battery Items')
@section('frontend_contents')

    {{-- BREADCRUMB --}}
    <section class="page-header battery-page-header mb-5">
        <div class="page-header-bg" style="background-image:url({{ asset('frontend/assets/static_images/breadcrumb.jpg') }})"></div>
        <div class="container">
            <div class="page-header__inner">
                <h2>Battery Items</h2>
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><span>//</span></li>
                    <li>Battery Items</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- AD SLIDER --}}
    @if ($ads->count())
        <section class="mb-2">
            <div class="container">
                <div id="batteryAdSlider" class="carousel slide battery-slider" data-bs-ride="carousel">
                    <div class="carousel-inner rounded-4 overflow-hidden">
                        @foreach ($ads as $i => $ad)
                            <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                                @if ($ad->link)
                                    <a href="{{ $ad->link }}" target="_blank">
                                        <img src="{{ asset($ad->image) }}" class="d-block w-100 battery-slider-img" alt="{{ $ad->title }}">
                                    </a>
                                @else
                                    <img src="{{ asset($ad->image) }}" class="d-block w-100 battery-slider-img" alt="{{ $ad->title }}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                    @if ($ads->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#batteryAdSlider" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#batteryAdSlider" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- MAIN SECTION --}}
    <section class="product">
        <div class="container">
            <div class="row">

                {{-- SIDEBAR --}}
                <div class="col-xl-3 col-lg-3">
                    <div class="product__sidebar">

                        <div class="shop-category product__sidebar-single">
                            <h3 class="product__sidebar-title">Categories</h3>

                            @foreach ($battery_categories as $bCat)
                                @php $count = $modules->where('battery_category_id', $bCat->id)->count(); @endphp
                                @if ($count > 0)
                                    <label class="filter-check">
                                        <input type="checkbox" class="js-filter-battery-category" value="{{ $bCat->id }}">
                                        {{ $bCat->name }} ({{ $count }})
                                    </label>
                                @endif
                            @endforeach

                            @php $uncatCount = $modules->whereNull('battery_category_id')->count(); @endphp
                            @if ($uncatCount > 0)
                                <label class="filter-check">
                                    <input type="checkbox" class="js-filter-battery-category" value="0">
                                    Uncategorized ({{ $uncatCount }})
                                </label>
                            @endif
                        </div>

                    </div>
                </div>

                {{-- RIGHT CONTENT --}}
                <div class="col-xl-9 col-lg-9">

                    <div class="shop-search product__sidebar-single product__price-ranger">
                        <div class="custom-sidebar-search js-sidebar-search">
                            <input type="text" id="batterySearch" class="custom-sidebar-search__input" placeholder="Search battery items..." autocomplete="off">
                        </div>
                    </div>

                    <div class="product__items">

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="product__showing-result d-flex justify-content-between align-items-center">
                                    <a href="#!" id="clear-all-filters" style="display:none;color:red;text-decoration:underline;">Clear All</a>
                                    <div id="clear-all-placeholder" style="visibility:hidden;flex:0 0 auto;color:red;text-decoration:underline;">Clear All</div>
                                    <div class="product__showing-text-box">
                                        <p class="product__showing-text">
                                            Showing <span id="visibleCount">{{ $modules->count() }}</span> of {{ $modules->count() }} items
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PRODUCT CARDS --}}
                        <div class="product__all">
                            <div class="row align-items-stretch" id="battery-grid">

                                @forelse ($modules as $module)
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 custom_product_margin battery-card-wrap" data-name="{{ strtolower($module->product_name) }}" data-category-id="{{ $module->battery_category_id ?? 0 }}" data-desc="{{ strtolower($module->product_description ?? '') }}">

                                        <div class="product__all-single h-100 d-flex flex-column">

                                            <a href="{{ route('product.details', $module->product_slug) }}">
                                                <div class="product__all-img">
                                                    <img src="{{ asset($module->product_image ?? 'upload/no_image.jpg') }}" alt="{{ $module->product_name }}">
                                                </div>
                                            </a>

                                            <div class="product__all-content mt-auto">

                                                {{-- Brand Name (like other product pages) --}}
                                                <span class="product__category">
                                                    <a href="{{ route('product.by.brand', $module->brand->product_brand_slug) }}">{{ $module->brand->product_brand_name ?? '—' }}</a>
                                                </span>

                                                <h4 class="product__all-title">
                                                    <a href="{{ route('product.details', $module->product_slug) }}">
                                                        {{ Str::limit($module->product_name, 40) }}
                                                    </a>
                                                </h4>

                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="text-center py-5 text-muted">No battery items found.</p>
                                    </div>
                                @endforelse

                            </div>

                            <div id="noResult" class="text-center py-5 d-none">
                                <i class="bx bx-search-alt" style="font-size:55px;color:#cfd6e0;"></i>
                                <p class="text-muted mt-3 mb-0">No battery item found</p>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <style>
        .battery-slider-img {
            height: 380px;
            object-fit: cover;
        }

        @media(max-width:767px) {
            .battery-slider-img {
                height: 180px;
            }
        }
    </style>

    <script>
        function applyBatteryFilter() {
            const search = document.getElementById('batterySearch').value.toLowerCase().trim();
            const checkedCategories = [...document.querySelectorAll('.js-filter-battery-category:checked')].map(el => el.value);
            const cards = document.querySelectorAll('.battery-card-wrap');
            let visible = 0;

            cards.forEach(card => {
                const name = card.dataset.name || '';
                const desc = card.dataset.desc || '';
                const categoryId = card.dataset.categoryId || '0';

                const matchSearch = !search || name.includes(search) || desc.includes(search);
                const matchCategory = checkedCategories.length === 0 || checkedCategories.includes(categoryId);

                if (matchSearch && matchCategory) {
                    card.style.display = '';
                    visible++;
                } else {
                    card.style.display = 'none';
                }
            });

            document.getElementById('visibleCount').textContent = visible;
            document.getElementById('noResult').classList.toggle('d-none', visible > 0);
            checkBatteryFilters();
        }

        function checkBatteryFilters() {
            const hasCategory = document.querySelectorAll('.js-filter-battery-category:checked').length > 0;
            const hasSearch = document.getElementById('batterySearch').value.trim().length > 0;

            if (hasCategory || hasSearch) {
                document.getElementById('clear-all-filters').style.display = 'inline-block';
                document.getElementById('clear-all-placeholder').style.display = 'none';
            } else {
                document.getElementById('clear-all-filters').style.display = 'none';
                document.getElementById('clear-all-placeholder').style.display = 'block';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('batterySearch').addEventListener('keyup', applyBatteryFilter);
            document.querySelectorAll('.js-filter-battery-category').forEach(el => el.addEventListener('change', applyBatteryFilter));
            document.getElementById('clear-all-filters').addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('batterySearch').value = '';
                document.querySelectorAll('.js-filter-battery-category').forEach(el => el.checked = false);
                applyBatteryFilter();
            });
        });
    </script>

@endsection
