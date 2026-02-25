<section class="services-two product">

    <div class="container">

        <div class="section-title section-title--two text-center">
            <span class="section-title__tagline">OUR PRODUCT</span>
            <h2 class="section-title__title">Latest Product</h2>
        </div>

        <div class="row">

            <div class="col-xl-12 col-lg-12">

                <div class="product__items">

                    <div class="product__all">

                        <div class="row">

                            @foreach ($product_data as $item)
                                <div class="col-xl-3 col-lg-3 col-md-6 custom_product_margin">

                                    <div class="product__all-single">

                                        <a href="{{ route('product.details', $item->product_slug) }}">
                                            <div class="product__all-img">
                                                <img src="{{ asset($item->product_image) }}" alt="">
                                            </div>
                                        </a>

                                        <div class="product__all-content">

                                            <span class="product__category">{{ $item->category->product_category_name ?? 'Uncategorized' }}</span>

                                            <h4 class="product__all-title">
                                                <a href="{{ route('product.details', $item->product_slug) }}">
                                                    {{ Str::limit($item->product_name, 40) }}
                                                </a>
                                            </h4>

                                            {{-- <p class="product__all-price mt-2">
                                                <span class="new__price">
                                                    ${{ number_format($item->product_price - ($item->discount_price ?? 0), 2) }}
                                                </span>
                                                @if ($item->discount_price > 0)
                                                    <span class="old__price">
                                                        ${{ number_format($item->product_price, 2) }}
                                                    </span>
                                                @endif
                                            </p> --}}

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        </div>

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 text-center mt-3">
                                <a href="{{ route('products') }}" class="welcome-one__btn thm-btn">View All</a>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
