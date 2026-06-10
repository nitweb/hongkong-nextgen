@forelse ($products as $item)
    <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 custom_product_margin">
        <div class="product__all-single h-100 d-flex flex-column">
            <a href="{{ route('product.details', $item->product_slug) }}">
                <div class="product__all-img">
                    <img src="{{ asset($item->product_image) }}" alt="">
                </div>
            </a>
            <div class="product__all-content mt-auto">
                <span class="product__category">
                    <a href="{{ route('product.by.category', $item->category->product_category_slug ?? '#') }}">{{ $item->category->product_category_name ?? 'Uncategorized' }}</a>
                </span>
                <h4 class="product__all-title">
                    <a href="{{ route('product.details', $item->product_slug) }}">
                        {{ Str::limit($item->product_name, 40) }}
                    </a>
                </h4>
            </div>
        </div>
    </div>
@empty
    <div class="col-xl-12">
        <p>No products found.</p>
    </div>
@endforelse
