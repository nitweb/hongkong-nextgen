<div class="row" id="product-grid">
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
</div>

@if ($products->hasPages())
    <div class="row">
        <div class="col-xl-12">
            <div class="blog-page__pagination">
                <ul class="pg-pagination list-unstyled">
                    @if (!$products->onFirstPage())
                        <li class="prev">
                            <a href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                                <i class="fa fa-angle-double-left"></i>
                            </a>
                        </li>
                    @endif

                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        <li class="count {{ $page == $products->currentPage() ? 'active' : '' }}">
                            <a href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    @if ($products->hasMorePages())
                        <li class="next">
                            <a href="{{ $products->nextPageUrl() }}" aria-label="Next">
                                <i class="fa fa-angle-double-right"></i>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endif
