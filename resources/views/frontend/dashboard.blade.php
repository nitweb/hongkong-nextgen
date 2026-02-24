<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>@yield('frontend_title') || Hongkong NextGen</title>

    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/assets/images/favicons/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend/assets/images/favicons/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend/assets/images/favicons/favicon-16x16.png') }}" />
    <link rel="manifest" href="{{ asset('frontend/assets/images/favicons/site.webmanifest') }}" />
    <meta name="description" content="Hongkong NextGen" />

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Saira:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/animate/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/animate/custom-animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/fontawesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/jarallax/jarallax.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/nouislider/nouislider.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/nouislider/nouislider.pips.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/odometer/odometer.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/swiper/swiper.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/jetly-icons/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/tiny-slider/tiny-slider.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/reey-font/stylesheet.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/owl-carousel/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/owl-carousel/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/bxslider/jquery.bxslider.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/bootstrap-select/css/bootstrap-select.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/vegas/vegas.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/jquery-ui/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/timepicker/timePicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/nice-select/nice-select.css') }}" />

    <!-- template styles -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/fixnix.css') }}?v={{ time() }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/fixnix-responsive.css') }}" />

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}?v={{ time() }}" />
</head>

<body class="custom-cursor">

    <div class="page-wrapper">

        {{-- Header Area --}}
        @include('frontend.layout.header')

        {{-- Index Area --}}
        @yield('frontend_contents')

        {{-- Footer Area --}}
        @include('frontend.layout.footer')

    </div>

    {{-- Mobile Navigation --}}
    @include('frontend.layout.mobile_nav')

    {{-- Search Popup --}}
    @include('frontend.layout.search')

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="icon-right-arrow"></i></a>

    <script src="{{ asset('frontend/assets/vendors/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/jarallax/jarallax.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/jquery-appear/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/jquery-circle-progress/jquery.circle-progress.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/odometer/odometer.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/swiper/swiper.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/tiny-slider/tiny-slider.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/wnumb/wNumb.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/wow/wow.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/isotope/isotope.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/countdown/countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/bxslider/jquery.bxslider.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/vegas/vegas.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/timepicker/timePicker.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/circleType/jquery.circleType.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/circleType/jquery.lettering.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/nice-select/jquery.nice-select.min.js') }}"></script>

    <!-- template js -->
    <script src="{{ asset('frontend/assets/js/fixnix.js') }}?v={{ time() }}"></script>

    {{-- Custom JS --}}
    @include('frontend.layout.custom_scripts')
</body>

</html>
