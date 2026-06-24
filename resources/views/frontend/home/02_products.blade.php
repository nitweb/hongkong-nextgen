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

                        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-5 align-items-stretch">

                            @foreach ($product_data as $item)
                                <div class="col custom_product_margin">

                                    <div class="product__all-single h-100 d-flex flex-column">
                                        <a href="{{ route('product.details', $item->product_slug) }}">
                                            <div class="product__all-img">
                                                <img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}">
                                            </div>
                                        </a>

                                        <div class="product__all-content text-center mt-auto">
                                            <span class="product__category">
                                                <a href="{{ route('product.by.brand', $item->brand->product_brand_slug ?? '#!') }}">{{ $item->brand->product_brand_name ?? 'Uncategorized' }}</a>
                                            </span>

                                            <h4 class="product__all-title">
                                                <a href="{{ route('product.details', $item->product_slug) }}">
                                                    {{ Str::limit($item->product_name, 40) }}
                                                </a>
                                            </h4>
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
