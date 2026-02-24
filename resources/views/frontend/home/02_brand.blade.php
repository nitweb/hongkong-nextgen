<section class="services-three">

    <div class="about-one__bg float-bob-y" style="background-image: url({{ asset('frontend/assets/images/backgrounds/about-one-bg-img-1.jpg') }});"></div>

    <div class="container">

        <div class="section-title section-title--two text-center">
            <span class="section-title__tagline">OUR BRANDS</span>
            <h2 class="section-title__title">Brands We Repair</h2>
        </div>

        <div class="row">

            @foreach ($product_brand_data as $item)
                <div class="col-xl-3 col-lg-3 custom_product_margin wow fadeInUp" data-wow-delay="100ms">
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

        <div class="row">
            <div class="col-xl-12 col-lg-12 text-center mt-3">
                <a href="{{ route('brands') }}" class="welcome-one__btn thm-btn">View All</a>
            </div>
        </div>

    </div>

</section>
