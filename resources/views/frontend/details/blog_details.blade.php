@extends('frontend.dashboard')
@section('frontend_title', $blog_details->blog_title)
@section('frontend_contents')

    {{-- Breadcrumb --}}
    <section class="page-header">
        <div class="page-header-bg" style="background-image: url({{ asset('frontend/assets/static_images/breadcrumb.jpg') }})"></div>
        <div class="container">
            <div class="page-header__inner">
                <h2>{{ $blog_details->blog_title }}</h2>
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><span>//</span></li>
                    <li>Blog Details</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Blog Details Area --}}
    <section class="blog-sidebar">

        <div class="container">

            <div class="row">

                <div class="col-xl-8 col-lg-7">

                    <div class="blog-sidebar__left">

                        <div class="blog-sidebar__img-box">
                            <div class="blog-sidebar__img">
                                <img src="{{ asset('upload/blog_image/' . $blog_details->blog_image) }}" alt="{{ $blog_details->blog_title }}">
                            </div>
                        </div>

                        <div class="blog-details-two__top">

                            <h3 class="blog-details-two__top-title">{{ $blog_details->blog_title }}</h3>

                            <ul class="blog-details-two__top-meta-list list-unstyled">
                                <li>
                                    <a href="#"><i class="fa fa-user"></i>{{ $blog_details->blogPublisher->name }}</a>
                                    <a href="#"><i class="fa fa-calendar-alt"></i>{{ \Carbon\Carbon::parse($blog_details->blog_published_date)->format('d F Y') }}</a>
                                    <a href="#"><i class="fa fa-tags"></i>{{ $blog_details->blogCategory->blog_category_name ?? 'Uncategorized' }}</a>
                                </li>
                            </ul>

                        </div>

                        <div class="blog-sidebar__text-1" style="text-align: justify;">
                            {!! $blog_details->blog_long_description !!}
                        </div>

                        @if ($blog_details->blog_tags)
                            <p class="blog-details__tags">
                                <span>Tags:</span>
                                @foreach (explode(',', $blog_details->blog_tags) as $tag)
                                    <a href="#!">{{ trim($tag) }}</a>
                                @endforeach
                            </p>
                        @endif


                    </div>

                </div>

                <div class="col-xl-4 col-lg-5">

                    <div class="sidebar">

                        {{-- <div class="sidebar__single sidebar__search">
                            <form action="#" class="sidebar__search-form">
                                <input type="search" placeholder="Search here">
                                <button type="submit"><i class="icon-search-interface-symbol"></i></button>
                            </form>
                        </div> --}}

                        {{-- <div class="sidebar__single sidebar__category">
                            <h3 class="sidebar__title">Categories</h3>
                            <ul class="sidebar__category-list list-unstyled">
                                @foreach ($blog_category as $item)
                                    <li>
                                        <a href="#!">
                                            <span class="icon-play-1"></span>
                                            {{ $item->blog_category_name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div> --}}

                        <div class="sidebar__single sidebar__post">
                            <h3 class="sidebar__title">Latest Posts</h3>
                            <ul class="sidebar__post-list list-unstyled">
                                @foreach ($blog_list as $recent)
                                    <li>
                                        <div class="sidebar__post-image">
                                            <img src="{{ asset('upload/blog_image/' . $recent->blog_image) }}" alt="{{ $recent->blog_title }}">
                                        </div>
                                        <div class="sidebar__post-content">
                                            <h3>
                                                <a href="{{ route('blog.details', $recent->blog_slug) }}">
                                                    {{ Str::limit($recent->blog_title, 50) }}
                                                </a>
                                            </h3>
                                            <p>{{ \Carbon\Carbon::parse($recent->blog_published_date)->format('d F Y') }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="sidebar__single sidebar__get-in-touch">
                            <h3 class="sidebar__title">Get in touch</h3>
                            <ul class="sidebar__get-in-touch-list list-unstyled">
                                <li>
                                    <div class="icon">
                                        <span class="icon-send"></span>
                                    </div>
                                    <div class="text">
                                        <h3>
                                            {!! GlobalSiteSettings()->site_address !!}
                                        </h3>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-mail"></span>
                                    </div>
                                    <div class="text">
                                        <h3><a href="mailto:{{ GlobalSiteSettings()->site_email }}">{{ GlobalSiteSettings()->site_email }}</a></h3>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-call"></span>
                                    </div>
                                    <div class="text">
                                        <h3><a href="tel:{{ GlobalSiteSettings()->site_phone }}">{{ GlobalSiteSettings()->site_phone }}</a></h3>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection
