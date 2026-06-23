@extends('frontend.dashboard')
@section('frontend_title', 'Home')
@section('frontend_contents')

    {{-- Slider Area --}}
    @include('frontend.home.01_slider')

    {{-- Product Area --}}
    @include('frontend.home.02_products')

    {{-- Brand Area --}}
    @include('frontend.home.03_brand')

    {{-- Industries We Serve Area --}}
    @include('frontend.home.04_industries_we_serve')

    {{-- Certificate Area --}}
    @include('frontend.home.05_certificate')

@endsection
