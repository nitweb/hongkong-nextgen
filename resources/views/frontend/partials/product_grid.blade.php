@forelse ($products as $item)
    <div class="col-xl-4 col-lg-4 col-md-6 custom_product_margin">
        <div class="product__all-single">
            <a href="{{ route('product.details', $item->product_slug) }}">
                <div class="product__all-img">
                    <img src="{{ asset($item->product_image) }}" alt="">
                </div>
            </a>
            <div class="product__all-content">
                <span class="product__category">
                    {{ $item->category->product_category_name ?? 'Uncategorized' }}
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
