<section class="services-three" style="margin-bottom: -20px;">

    <div class="about-one__bg float-bob-y" style="background-image: url({{ asset('frontend/assets/images/backgrounds/about-one-bg-img-1.jpg') }});"></div>

    <div class="container">

        <div class="section-title section-title--two text-center">
            <span class="section-title__tagline">OUR BRANDS</span>
            <h2 class="section-title__title">Brands We Repair</h2>
        </div>

        {{-- <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-5 align-items-stretch">

            @foreach ($product_brand_data as $item)
                <div class="col custom_product_margin wow fadeInUp" data-wow-delay="100ms">
                    <div class="services-three__single h-100 d-flex flex-column">
                        <div class="services-three__img-box">
                            <a href="{{ route('product.by.brand', $item->product_brand_slug) }}">
                                <div class="services-three__img">
                                    <img src="{{ !empty($item->product_brand_image) ? url('upload/product_brand_image/' . $item->product_brand_image) : url('upload/no_image.jpg') }}" alt="{{ $item->product_brand_name }}">
                                </div>
                            </a>
                        </div>
                        <h3 class="services-three__title mt-auto text-center">
                            <a href="{{ route('product.by.brand', $item->product_brand_slug) }}">{{ $item->product_brand_name }}</a>
                        </h3>
                    </div>
                </div>
            @endforeach

        </div> --}}

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

        <div class="row">
            <div class="col-xl-12 col-lg-12 text-center mt-3">
                <a href="{{ route('brands') }}" class="welcome-one__btn thm-btn">View All</a>
            </div>
        </div>

    </div>

</section>
