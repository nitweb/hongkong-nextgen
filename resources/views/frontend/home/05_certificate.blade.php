<section class="services-two">

    <div class="container">

        <div class="section-title section-title--two text-center">
            <span class="section-title__tagline">Qualification Certificate</span>
            <h2 class="section-title__title">Certified for Excellence</h2>
        </div>

        <div class="row">

            @foreach ($certificate_data as $item)
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp custom_certificate_margin" data-wow-delay="100ms">
                    <div class="certificate-box">
                        <div class="certificate-img">
                            <img src="{{ !empty($item->certificate_image) ? url('upload/certificate_image/' . $item->certificate_image) : url('upload/no_image.jpg') }}" alt="{{ $item->certificate_title }}">
                        </div>
                        <h3 class="certificate-title">{{ $item->certificate_title }}</h3>
                    </div>
                </div>
            @endforeach

        </div>

    </div>

</section>
