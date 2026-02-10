<section class="services-three">

    <div class="about-one__bg float-bob-y" style="background-image: url({{ asset('frontend/assets/images/backgrounds/about-one-bg-img-1.jpg') }});"></div>

    <div class="container">

        <div class="section-title section-title--two text-center">
            <span class="section-title__tagline">OUR BRANDS</span>
            <h2 class="section-title__title">Brands We Repair</h2>
        </div>

        <div class="row">

            @foreach ($product_brand_data as $item)
                <div class="col-xl-3 col-lg-3 wow fadeInUp" data-wow-delay="100ms">
                    <div class="services-three__single">
                        <div class="services-three__img-box">
                            <div class="services-three__img">
                                <img src="{{ !empty($item->product_brand_image) ? url('upload/product_brand_image/' . $item->product_brand_image) : url('upload/no_image.jpg') }}" alt="{{ $item->product_brand_name }}">
                            </div>
                        </div>
                        <h3 class="services-three__title">
                            <a href="#!">{{ $item->product_brand_name }}</a>
                        </h3>
                    </div>
                </div>
            @endforeach

        </div>

    </div>

</section>
