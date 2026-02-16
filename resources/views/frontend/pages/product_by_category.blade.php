@extends('frontend.dashboard')
@section('frontend_title', $category->product_category_name ?? 'Products')

@section('frontend_contents')

    {{-- ================= Breadcrumb ================= --}}
    <section class="page-header">
        <div class="page-header-bg" style="background-image: url({{ asset('frontend/assets/static_images/breadcrumb.jpg') }})">
        </div>

        <div class="container">
            <div class="page-header__inner">
                <h2>{{ $category->product_category_name }}</h2>
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><span>//</span></li>
                    <li><a href="{{ route('products') }}">Product</a></li>
                    <li><span>//</span></li>
                    <li>Category</li>
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

                        {{-- Search --}}
                        <div class="shop-search product__sidebar-single">
                            <form action="" method="GET">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products">
                            </form>
                        </div>

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


                    </div>
                </div>

                {{-- Products --}}
                <div class="col-xl-9 col-lg-9">
                    <div class="product__items">

                        {{-- Showing result --}}
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="product__showing-result">
                                    <p class="product__showing-text">
                                        Showing {{ $product_data->firstItem() ?? 0 }}
                                        –
                                        {{ $product_data->lastItem() ?? 0 }}
                                        of {{ $product_data->total() }} results
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Product list --}}
                        <div class="product__all">
                            <div class="row">

                                @forelse ($product_data as $item)
                                    <div class="col-xl-4 col-lg-4 col-md-6">
                                        <div class="product__all-single">

                                            <a href="{{ route('product.details', $item->product_slug) }}">
                                                <div class="product__all-img">
                                                    <img src="{{ asset('upload/product_image/' . ($item->product_image ?? 'default.png')) }}" alt="{{ $item->product_name }}">
                                                </div>
                                            </a>

                                            <div class="product__all-content">
                                                <span class="product__category">
                                                    {{ $item->category->product_category_name }}
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

                                                    @if ($item->discount_price)
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
