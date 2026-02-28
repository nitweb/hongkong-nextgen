@extends('frontend.dashboard')
@section('frontend_title', 'Flash Sale')
@section('frontend_contents')

    {{-- Breadcrumb --}}
    <section class="page-header">
        <div class="page-header-bg" style="background-image: url({{ asset('frontend/assets/static_images/breadcrumb.jpg') }})"></div>
        <div class="container">
            <div class="page-header__inner">
                <h2>Flash Sale</h2>
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><span>//</span></li>
                    <li>Flash Sale</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Product Area --}}
    <section class="product">
        <div class="container">
            <div class="row">

                <div class="col-xl-3 col-lg-3">
                    <div class="product__sidebar">

                        {{-- <div class="shop-category product__sidebar-single">
                            <h3 class="product__sidebar-title">Categories</h3>

                            <ul class="list-unstyled">
                                @foreach ($category_data as $cat)
                                    <li class="{{ request()->route('slug') == $cat->product_category_slug ? 'active' : '' }}">
                                        <a href="{{ route('product.by.category', $cat->product_category_slug) }}">
                                            {{ $cat->product_category_name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div> --}}

                        <div class="shop-category product__sidebar-single">
                            <h3 class="product__sidebar-title">Brands</h3>
                            <ul class="list-unstyled">
                                @foreach ($product_brand_data as $item)
                                    <li class="{{ request()->route('slug') == $item->product_brand_slug ? 'active' : '' }}">
                                        <a href="{{ route('product.by.brand', $item->product_brand_slug) }}">{{ $item->product_brand_name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>

                <div class="col-xl-9 col-lg-9">

                    {{-- Search Product --}}
                    <div class="shop-search product__sidebar-single product__price-ranger">
                        <div class="custom-sidebar-search js-sidebar-search">
                            <input type="text" class="custom-sidebar-search__input js-ajax-search-input" placeholder="Search products..." autocomplete="off">
                            <div class="custom-sidebar-search__result js-ajax-search-result"></div>
                        </div>
                    </div>

                    <div class="product__items">

                        {{-- Showing result --}}
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="product__showing-result">
                                    <div class="product__showing-text-box">
                                        <p class="product__showing-text">
                                            Showing {{ $product_data->firstItem() ?? 0 }}–{{ $product_data->lastItem() ?? 0 }}
                                            of {{ $product_data->total() }} results
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product__all">
                            <div class="row">
                                <div class="col-xl-12">
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
                                                @forelse ($product_data as $item)
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

                                                        {{-- Quantity (flash_sale_quantity) --}}
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

                                                        {{-- Inquiry Button → opens modal with product pre-filled --}}
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
                                </div>
                            </div>

                            {{-- Pagination --}}
                            @if ($product_data->hasPages())
                                <div class="row mt-3">
                                    <div class="col-xl-12">
                                        <div class="blog-page__pagination">
                                            <ul class="pg-pagination list-unstyled">

                                                @if (!$product_data->onFirstPage())
                                                    <li class="prev">
                                                        <a href="{{ $product_data->previousPageUrl() }}" aria-label="Previous">
                                                            <i class="fa fa-angle-double-left"></i>
                                                        </a>
                                                    </li>
                                                @endif

                                                @foreach ($product_data->getUrlRange(1, $product_data->lastPage()) as $page => $url)
                                                    <li class="count {{ $page == $product_data->currentPage() ? 'active' : '' }}">
                                                        <a href="{{ $url }}">{{ $page }}</a>
                                                    </li>
                                                @endforeach

                                                @if ($product_data->hasMorePages())
                                                    <li class="next">
                                                        <a href="{{ $product_data->nextPageUrl() }}" aria-label="Next">
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
                    </div>
                </div>


                {{-- ============================================================ --}}
                {{-- INQUIRY MODAL (reused from product details, works for table) --}}
                {{-- ============================================================ --}}
                <div class="modal fade" id="flashSaleInquiryModal" tabindex="-1" aria-labelledby="flashSaleInquiryModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="flashSaleInquiryModalLabel">Order Request</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form id="flashSaleInquiryForm" action="{{ route('bulk.order.submit') }}" method="POST">
                                @csrf
                                {{-- dynamically filled by JS --}}
                                <input type="hidden" name="product_id" id="inquiry_product_id" value="">

                                <div class="modal-body">

                                    {{-- Show selected product name for clarity --}}
                                    <div class="mb-3">
                                        <p style="font-size:13px; color:#555; margin-bottom:4px;">Product:</p>
                                        <p id="inquiry_product_name" style="font-weight:600; color:#333; margin:0;"></p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Quantity</label>
                                        <input type="number" name="quantity" min="1" class="form-control" required>
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label">Message</label>
                                        <textarea name="message" rows="4" class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="thm-btn custom_thn_btn" id="flashSaleSubmitBtn">Submit</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>


                {{-- ============================================================ --}}
                {{-- SCRIPTS                                                      --}}
                {{-- ============================================================ --}}
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

                <script>
                    $(document).ready(function() {

                        // ✅ Toastr options
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 3500,
                            positionClass: "toast-top-right"
                        };

                        // ✅ When Inquiry button is clicked → fill hidden product_id & product name into modal
                        $(document).on('click', '.inquiry-btn', function() {
                            const productId = $(this).data('product-id');
                            const productName = $(this).data('product-name');

                            $('#inquiry_product_id').val(productId);
                            $('#inquiry_product_name').text(productName);
                        });

                        // ✅ Reset form when modal is closed
                        $('#flashSaleInquiryModal').on('hidden.bs.modal', function() {
                            $('#flashSaleInquiryForm')[0].reset();
                            $('#inquiry_product_id').val('');
                            $('#inquiry_product_name').text('');
                        });

                        // ✅ AJAX form submit
                        $('#flashSaleInquiryForm').submit(function(e) {
                            e.preventDefault();

                            const $form = $(this);
                            const $btn = $('#flashSaleSubmitBtn');

                            $btn.prop('disabled', true).text('Submitting...');

                            $.ajax({
                                url: $form.attr('action'),
                                method: 'POST',
                                data: $form.serialize(),
                                success: function(response) {
                                    toastr.success(response.message || 'Your inquiry has been submitted successfully!');

                                    const modalEl = document.getElementById('flashSaleInquiryModal');
                                    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                                    modal.hide();

                                    $form[0].reset();
                                    $('#inquiry_product_id').val('');
                                    $('#inquiry_product_name').text('');
                                },
                                error: function(xhr) {
                                    if (xhr.status === 422) {
                                        let errors = xhr.responseJSON.errors;
                                        for (let key in errors) {
                                            toastr.error(errors[key][0]);
                                        }
                                    } else {
                                        toastr.error('Something went wrong. Please try again.');
                                    }
                                },
                                complete: function() {
                                    $btn.prop('disabled', false).text('Submit');
                                }
                            });
                        });

                    });
                </script>

            </div>

        </div>

    </section>

@endsection
