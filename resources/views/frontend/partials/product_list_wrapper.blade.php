<div class="row" id="product-grid">
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
