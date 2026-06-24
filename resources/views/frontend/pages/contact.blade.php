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
                                        <input type="text" placeholder="Name" name="contact_form_name" value="{{ old('contact_form_name') }}" required>
                                        @error('contact_form_name')
                                            <span class="error-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="contact-page__form-input-box">
                                        <input type="email" placeholder="Email" name="contact_form_email" value="{{ old('contact_form_email') }}" required>
                                        @error('contact_form_email')
                                            <span class="error-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="contact-page__form-input-box">
                                        <input type="text" placeholder="Phone" name="contact_form_phone" value="{{ old('contact_form_phone') }}" required>
                                        @error('contact_form_phone')
                                            <span class="error-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="contact-page__form-input-box">
                                        <input type="text" placeholder="Subject" name="contact_form_subject" value="{{ old('contact_form_subject') }}" required>
                                        @error('contact_form_subject')
                                            <span class="error-text">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="contact-page__form-input-box text-message-box">
                                        <textarea name="contact_form_message" placeholder="Comment" required>{{ old('contact_form_message') }}</textarea>
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

                                    {{-- Address --}}
                                    <li class="has-address">
                                        <div class="icon">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1 1 18 0z" />
                                                <circle cx="12" cy="10" r="3" />
                                            </svg>
                                        </div>
                                        <div class="text">
                                            <span class="label">Address</span>
                                            <p>{!! GlobalSiteSettings()->site_address !!}</p>
                                        </div>
                                    </li>

                                    {{-- Person 1 --}}
                                    @if (GlobalSiteSettings()->person1_name)
                                        <li>
                                            <div class="icon">
                                                <svg viewBox="0 0 24 24">
                                                    <rect x="2" y="4" width="20" height="16" rx="2" />
                                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                                </svg>
                                            </div>
                                            <div class="text">
                                                <span class="label">{{ GlobalSiteSettings()->person1_name }}</span>
                                                @if (GlobalSiteSettings()->person1_email)
                                                    <a href="mailto:{{ GlobalSiteSettings()->person1_email }}">
                                                        {{ GlobalSiteSettings()->person1_email }}
                                                    </a>
                                                @endif
                                                @if (GlobalSiteSettings()->person1_phone)
                                                    <a href="tel:{{ GlobalSiteSettings()->person1_phone }}">
                                                        {{ GlobalSiteSettings()->person1_phone }}
                                                    </a>
                                                @endif
                                            </div>
                                        </li>
                                    @endif

                                    {{-- Person 2 --}}
                                    @if (GlobalSiteSettings()->person2_name)
                                        <li>
                                            <div class="icon">
                                                <svg viewBox="0 0 24 24">
                                                    <rect x="2" y="4" width="20" height="16" rx="2" />
                                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                                </svg>
                                            </div>
                                            <div class="text">
                                                <span class="label">{{ GlobalSiteSettings()->person2_name }}</span>
                                                @if (GlobalSiteSettings()->person2_email)
                                                    <a href="mailto:{{ GlobalSiteSettings()->person2_email }}">
                                                        {{ GlobalSiteSettings()->person2_email }}
                                                    </a>
                                                @endif
                                                @if (GlobalSiteSettings()->person2_phone)
                                                    <a href="tel:{{ GlobalSiteSettings()->person2_phone }}">
                                                        {{ GlobalSiteSettings()->person2_phone }}
                                                    </a>
                                                @endif
                                            </div>
                                        </li>
                                    @endif

                                    {{-- Person 3 --}}
                                    @if (GlobalSiteSettings()->person3_name)
                                        <li>
                                            <div class="icon">
                                                <svg viewBox="0 0 24 24">
                                                    <rect x="2" y="4" width="20" height="16" rx="2" />
                                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                                </svg>
                                            </div>
                                            <div class="text">
                                                <span class="label">{{ GlobalSiteSettings()->person3_name }}</span>
                                                @if (GlobalSiteSettings()->person3_email)
                                                    <a href="mailto:{{ GlobalSiteSettings()->person3_email }}">
                                                        {{ GlobalSiteSettings()->person3_email }}
                                                    </a>
                                                @endif
                                                @if (GlobalSiteSettings()->person3_phone)
                                                    <a href="tel:{{ GlobalSiteSettings()->person3_phone }}">
                                                        {{ GlobalSiteSettings()->person3_phone }}
                                                    </a>
                                                @endif
                                            </div>
                                        </li>
                                    @endif

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
       
            {!! GlobalSiteSettings()->site_google_map !!}
       
    </section>

@endsection
