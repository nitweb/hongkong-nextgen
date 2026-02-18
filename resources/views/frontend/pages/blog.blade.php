@extends('frontend.dashboard')
@section('frontend_title', 'Blog')
@section('frontend_contents')

    {{-- Breadcrumb --}}
    <section class="page-header">
        <div class="page-header-bg" style="background-image: url({{ asset('frontend/assets/static_images/breadcrumb.jpg') }})"></div>
        <div class="container">
            <div class="page-header__inner">
                <h2>Blog</h2>
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><span>//</span></li>
                    <li>Blog</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Blog Area --}}
    <section class="blog-page-v-2">

        <div class="container">

            <div class="row">

                @foreach ($blog_list as $blog)
                    <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                        <div class="blog-two__single">
                            <div class="blog-two__img">
                                <img src="{{ asset('upload/blog_image/' . $blog->blog_image) }}" alt="{{ $blog->blog_title }}">
                                <div class="blog-two__plus">
                                    <a href="{{ route('blog.details', $blog->blog_slug) }}"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="blog-two__content">
                                <div class="blog-two__date">
                                    <p>{{ \Carbon\Carbon::parse($blog->blog_published_date)->format('d M Y') }}</p>
                                </div>
                                <h3 class="blog-two__title">
                                    <a href="{{ route('blog.details', $blog->blog_slug) }}">
                                        {{ Str::limit($blog->blog_title, 60) }}
                                    </a>
                                </h3>
                                <p class="blog-two__text" style="text-align:justify;">
                                    {{ Str::limit($blog->blog_short_description, 150) }}
                                </p>
                                <a href="{{ route('blog.details', $blog->blog_slug) }}" class="blog-two__read-more">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            {{-- ✅ Template Pagination (dynamic) --}}
            @if ($blog_list->hasPages())
                <div class="row">
                    <div class="col-xl-12">
                        <div class="blog-page__pagination">
                            <ul class="pg-pagination list-unstyled">

                                {{-- Prev --}}
                                @if ($blog_list->onFirstPage())
                                    {{-- first page e prev dekhabo na (template e prev class nai) --}}
                                @else
                                    <li class="prev">
                                        <a href="{{ $blog_list->previousPageUrl() }}" aria-label="Previous">
                                            <i class="fa fa-angle-double-left"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- Pages --}}
                                @foreach ($blog_list->getUrlRange(1, $blog_list->lastPage()) as $page => $url)
                                    <li class="count {{ $page == $blog_list->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                {{-- Next --}}
                                @if ($blog_list->hasMorePages())
                                    <li class="next">
                                        <a href="{{ $blog_list->nextPageUrl() }}" aria-label="Next">
                                            <i class="fa fa-angle-double-right"></i>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
            @endif

        </div>

    </section>

@endsection
