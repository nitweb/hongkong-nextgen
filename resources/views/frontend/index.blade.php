@extends('frontend.dashboard')
@section('frontend_title', 'Home')
@section('frontend_contents')

    {{-- Slider Area --}}
    @include('frontend.home.01_slider')

    {{-- Product Area --}}
    @include('frontend.home.02_products')

    {{-- Brand Area --}}
    @include('frontend.home.03_brand')

    {{-- YouTube Videos --}}
    @include('frontend.home.04_youtube_videos')

    {{-- Industries We Serve Area --}}
    @include('frontend.home.05_industries_we_serve')

    {{-- Certificate Area --}}
    @include('frontend.home.06_certificate')

@endsection
