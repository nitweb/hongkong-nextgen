@extends('frontend.dashboard')
@section('frontend_title', 'Home')
@section('frontend_contents')

    <section class="error-page">

        <div class="error-page__bg" style="background-image: url({{ asset('frontend/assets/images/backgrounds/404-bg-img.jpg') }});"></div>

        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="error-page__inner">
                        <div class="error-page__title-box">
                            <h2 class="error-page__title">
                                <span class="clr-primary">404</span>
                            </h2>
                        </div>
                        <h3 class="error-page__tagline">Oops! Page Not Found!</h3>
                        <p class="error-page__text">The page you are looking for does not exist. It might have been
                            moved or deleted</p>
                        <a href="{{ route('index') }}" class="thm-btn error-page__btn">Back To Home</a>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
