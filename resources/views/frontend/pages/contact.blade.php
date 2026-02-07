@extends('frontend.dashboard')
@section('frontend_title', 'Contact Us')
@section('frontend_contents')

    {{-- Breadcrumb --}}
    <section class="page-header">
        <div class="page-header-bg" style="background-image: url({{ asset('frontend/assets/static_images/breadcrumb.jpg') }})"></div>
        <div class="container">
            <div class="page-header__inner">
                <h2>Contact Us</h2>
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><span>//</span></li>
                    <li>Contact Us</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Contact Section --}}
    <section class="contact-page">

        <div class="container">

            {{-- Center Alignment --}}
            <div class="row align-items-center">

                {{-- LEFT SIDE FORM --}}
                <div class="col-xl-6 col-lg-6">

                    <div class="contact-page__left">

                        <div class="contact-page__shape-1">
                            <img src="{{ asset('frontend/assets/images/shapes/contact-page-shape-1.png') }}" alt="">
                        </div>

                        <h3 class="contact-page__title">Leave a message</h3>

                        <form action="{{ route('contact.submit') }}" method="POST" class="contact-page__form">

                            @csrf

                            <div class="row">

                                <div class="col-xl-12">
                                    <div class="contact-page__form-input-box">
                                        <input type="text" placeholder="Name" name="contact_form_name" value="{{ old('contact_form_name') }}">
                                        @error('contact_form_name')
                                            <span class="error-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="contact-page__form-input-box">
                                        <input type="email" placeholder="Email" name="contact_form_email" value="{{ old('contact_form_email') }}">
                                        @error('contact_form_email')
                                            <span class="error-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="contact-page__form-input-box">
                                        <input type="text" placeholder="Phone" name="contact_form_phone" value="{{ old('contact_form_phone') }}">
                                        @error('contact_form_phone')
                                            <span class="error-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="contact-page__form-input-box">
                                        <input type="text" placeholder="Subject" name="contact_form_subject" value="{{ old('contact_form_subject') }}">
                                        @error('contact_form_subject')
                                            <span class="error-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="contact-page__form-input-box text-message-box">
                                        <textarea name="contact_form_message" placeholder="Comment">{{ old('contact_form_message') }}</textarea>
                                        @error('contact_form_message')
                                            <span class="error-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="contact-page__btn-box">
                                        <button type="submit" class="thm-btn contact-page__btn">
                                            Send Message
                                        </button>
                                    </div>
                                </div>

                            </div>

                        </form>

                    </div>

                </div>

                {{-- RIGHT SIDE CONTACT INFO --}}
                <div class="col-xl-6 col-lg-6">

                    <div class="contact-page__right">

                        <div class="section-title text-left">
                            <span class="section-title__tagline">Get in touch</span>
                            <h2 class="section-title__title">
                                Need any help or just want to say hi?
                                Contact us today
                            </h2>
                        </div>

                        <div class="contact-page__points-box-inner">

                            <div class="contact-page__points-box">

                                <ul class="contact-page__points-list list-unstyled">

                                    <li>
                                        <div class="icon">
                                            <span class="icon-send"></span>
                                        </div>
                                        <div class="text">
                                            <p>{!! GlobalSiteSettings()->site_address !!}</p>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="icon">
                                            <span class="icon-mail"></span>
                                        </div>
                                        <div class="text">
                                            <p>
                                                <a href="mailto:{{ GlobalSiteSettings()->site_email }}">
                                                    {{ GlobalSiteSettings()->site_email }}
                                                </a>
                                            </p>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="icon">
                                            <span class="icon-call"></span>
                                        </div>
                                        <div class="text">
                                            <p>
                                                <a href="tel:{{ GlobalSiteSettings()->site_phone }}">
                                                    {{ GlobalSiteSettings()->site_phone }}
                                                </a>
                                            </p>
                                        </div>
                                    </li>

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
        
    </section>

    {{-- Google Map --}}
    <section class="google-map">
        <div class="container">
            {!! GlobalSiteSettings()->site_google_map !!}
        </div>
    </section>

@endsection
