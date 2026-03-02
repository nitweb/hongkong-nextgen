<div class="table-responsive">
    <table class="table" style="border-collapse: collapse; width: 100%; font-size: 14px;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th style="padding: 12px 16px; text-align: center; font-weight: 500; color: #555; border: 1px solid #ddd;">Part No</th>
                <th style="padding: 12px 16px; text-align: center; font-weight: 500; color: #555; border: 1px solid #ddd;">Brand</th>
                <th style="padding: 12px 16px; text-align: center; font-weight: 500; color: #555; border: 1px solid #ddd;">Package</th>
                <th style="padding: 12px 16px; text-align: center; font-weight: 500; color: #555; border: 1px solid #ddd;">Quantity</th>
                <th style="padding: 12px 16px; text-align: center; font-weight: 500; color: #555; border: 1px solid #ddd;">PDF</th>
                <th style="padding: 12px 16px; text-align: center; font-weight: 500; color: #555; border: 1px solid #ddd;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $item)
                <tr style="border-bottom: 1px solid #ddd;">

                    {{-- Part No --}}
                    <td style="padding: 14px 16px; text-align: center; border: 1px solid #ddd;">
                        <a href="{{ route('product.details', $item->product_slug) }}" style="color: #4a90d9; text-decoration: none;">
                            {{ $item->product_part_number }}
                        </a>
                    </td>

                    {{-- Brand --}}
                    <td style="padding: 14px 16px; text-align: center; color: #333; border: 1px solid #ddd;">
                        {{ $item->brand->product_brand_name ?? '' }}
                    </td>

                    {{-- Package --}}
                    <td style="padding: 14px 16px; text-align: center; color: #333; border: 1px solid #ddd;">
                        {{ $item->package ?? '' }}
                    </td>

                    {{-- Quantity --}}
                    <td style="padding: 14px 16px; text-align: center; color: #333; border: 1px solid #ddd;">
                        {{ $item->flash_sale_quantity ?? '' }}
                    </td>

                    {{-- PDF Download --}}
                    <td style="padding: 14px 16px; text-align: center; border: 1px solid #ddd;">
                        @if (!empty($item->flash_sale_pdf) && file_exists(public_path($item->flash_sale_pdf)))
                            <a href="{{ route('product.pdf.download', $item->id) }}" title="Download PDF" style="color: #e74c3c; font-size: 22px; text-decoration: none; display: inline-block;">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        @else
                            <span style="color: #ccc;">—</span>
                        @endif
                    </td>

                    {{-- Inquiry Button --}}
                    <td style="padding: 14px 16px; text-align: center; border: 1px solid #ddd;">
                        <button type="button" class="thm-btn inquiry-btn" style="padding: 6px 18px; font-size: 13px;" data-product-id="{{ $item->id }}" data-product-name="{{ $item->product_name }}" data-bs-toggle="modal" data-bs-target="#flashSaleInquiryModal">
                            Inquiry
                        </button>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6" style="padding: 20px; text-align: center; color: #777;">
                        No products found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if ($products->hasPages())
    <div class="row mt-3">
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
