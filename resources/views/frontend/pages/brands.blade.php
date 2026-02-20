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

            <div class="row">

                @foreach ($product_brand_data as $item)
                    <div class="col-xl-3 col-lg-3 wow fadeInUp" data-wow-delay="100ms">
                        <div class="services-three__single">
                            <div class="services-three__img-box">
                                <a href="{{ route('product.by.brand', $item->product_brand_slug) }}">
                                    <div class="services-three__img">
                                        <img src="{{ !empty($item->product_brand_image) ? url('upload/product_brand_image/' . $item->product_brand_image) : url('upload/no_image.jpg') }}" alt="{{ $item->product_brand_name }}">
                                    </div>
                                </a>
                            </div>
                            <h3 class="services-three__title">
                                <a href="{{ route('product.by.brand', $item->product_brand_slug) }}">{{ $item->product_brand_name }}</a>
                            </h3>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>

    </section>

@endsection
