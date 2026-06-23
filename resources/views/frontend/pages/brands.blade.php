@extends('frontend.dashboard')
@section('frontend_title', 'Brands')
@section('frontend_contents')

    {{-- Breadcrumb --}}
    <section class="page-header">
        <div class="page-header-bg" style="background-image: url({{ asset('frontend/assets/static_images/breadcrumb.jpg') }})"></div>
        <div class="container">
            <div class="page-header__inner">
                <h2>Brands</h2>
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><span>//</span></li>
                    <li>Brands</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Brands Area --}}
    <section class="services-three">

        <div class="container">

            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 row-cols-xl-6 align-items-stretch">

                @foreach ($product_brand_data as $item)
                    <div class="col custom_product_margin">

                        <div class="product__all-single h-100 d-flex flex-column">
                            <a href="{{ route('product.by.brand', $item->product_brand_slug) }}">
                                <div class="product__all-img">
                                    <img src="{{ !empty($item->product_brand_image) ? url('upload/product_brand_image/' . $item->product_brand_image) : url('upload/no_image.jpg') }}" alt="{{ $item->product_brand_name }}">
                                </div>
                            </a>

                            <div class="product__all-content text-center mt-auto">
                                <h4 class="product__all-title mt-0">
                                    <a href="{{ route('product.by.brand', $item->product_brand_slug) }}">{{ $item->product_brand_name }}</a>
                                </h4>
                            </div>
                        </div>

                    </div>
                @endforeach

            </div>

        </div>

    </section>

@endsection
