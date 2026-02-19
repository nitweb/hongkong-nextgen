@extends('frontend.dashboard')
@section('frontend_title', 'About Us')
@section('frontend_contents')

    {{-- Breadcrumb --}}
    <section class="page-header">
        <div class="page-header-bg" style="background-image: url({{ asset('frontend/assets/static_images/breadcrumb.jpg') }})"></div>
        <div class="container">
            <div class="page-header__inner">
                <h2>About Us</h2>
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><span>//</span></li>
                    <li>About Us</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- About Us Area --}}
    <section class="about-two about-page">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-xl-5 col-lg-6">
                    <div class="about-two__left">
                        <div class="about-two__img-box">
                            <div class="about-two__img">
                                <img src="{{ !empty($about_company->about_image) ? url('upload/about_image/' . $about_company->about_image) : url('upload/no_image.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-7 col-lg-6">
                    <div class="about-two__right">
                        <div class="section-title text-left">
                            <span class="section-title__tagline">About Us</span>
                            <h2 class="section-title__title">
                                We provide reliable and efficient solutions for all your technical needs.
                            </h2>
                        </div>
                        <div class="about-two__text-2" style="text-align: justify;">
                            {!! $about_company->about_description !!}
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section>


    {{-- MISSION/VISION/VALUES --}}
    <div class="company-details">

        <div class="container">

            <div class="row">

                @foreach ($mission_vision as $item)
                    <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                        <div class="company-details__single">
                            <div class="company-details__single-inner">
                                <div class="company-details__icon">
                                    <i class="{{ $item->mission_vision_icon }}" style="font-size: 30px; color: #f9f9f9;"></i>
                                </div>
                                <h3 class="company-details__title"><a href="#!">{{ $item->mission_vision_title }}</a></h3>
                                <p class="company-details__text">{{ $item->mission_vision_description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>

    </div>

@endsection
