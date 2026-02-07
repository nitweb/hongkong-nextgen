<section class="main-slider-two clearfix">

    <div class="swiper-container thm-swiper__slider" data-swiper-options='{"slidesPerView": 1, "loop": true,
                "effect": "fade",
                "pagination": {
                "el": "#main-slider-pagination",
                "type": "bullets",
                "clickable": true
                },
                "navigation": {
                "nextEl": "#main-slider__swiper-button-next",
                "prevEl": "#main-slider__swiper-button-prev"
                },
                "autoplay": {
                "delay": 5000
                }}'>

        <div class="swiper-wrapper">

            @foreach ($slider_data as $item)
                <div class="swiper-slide">
                    <div class="image-layer-two" style="background-image: url({{ !empty($item->slider_image) ? url('upload/slider_image/' . $item->slider_image) : url('upload/no_image.jpg') }});"></div>
                    <div class="container"></div>
                </div>
            @endforeach

        </div>

        <!-- If we need navigation buttons -->
        <div class="main-slider-two__nav">
            <div class="swiper-button-prev" id="main-slider__swiper-button-next">
                <i class="icon-left-arrow"></i>
            </div>
            <div class="swiper-button-next" id="main-slider__swiper-button-prev">
                <i class="icon-right-arrow"></i>
            </div>
        </div>

    </div>

</section>
