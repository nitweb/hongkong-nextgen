@extends('frontend.dashboard')
@section('frontend_title', 'Home')
@section('frontend_contents')

    {{-- Slider Area --}}
    @include('frontend.home.01_slider')

    {{-- Brand Area --}}
    @include('frontend.home.02_brand')

    {{-- Product Area --}}
    @include('frontend.home.03_products')

@endsection
