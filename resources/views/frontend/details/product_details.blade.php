@extends('frontend.dashboard')
@section('frontend_title', $product->product_name)
@section('frontend_contents')

    {{-- Breadcrumb --}}
    <section class="page-header">
        <div class="page-header-bg" style="background-image: url({{ asset('frontend/assets/static_images/breadcrumb.jpg') }})"></div>
        <div class="container">
            <div class="page-header__inner">
                <h2>{{ $product->product_name }}</h2>
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><span>//</span></li>
                    <li>Product Details</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Product Details --}}
    <section class="product-details">
        <div class="container">
            <div class="row">

                {{-- Image (always show) --}}
                <div class="col-lg-4 col-xl-4">
                    <div class="product-details__img">
                        <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}" />
                    </div>
                </div>

                <div class="col-lg-8 col-xl-8">

                    {{-- Product Name (always show) --}}
                    <div class="product-details__top">
                        <h3 class="product-details__title">
                            {{ $product->product_name }}
                        </h3>
                    </div>

                    <div class="product-details__reveiw" style="display: block;">

                        {{-- Brand (conditional) --}}
                        @if (!empty($product->brand))
                            <p class="details__brand"><strong>Brand:</strong>
                                <span>
                                    <a href="{{ route('product.by.brand', $product->brand->product_brand_slug) }}">
                                        {{ $product->brand->product_brand_name }}
                                    </a>
                                </span>
                            </p>
                        @endif

                        {{-- Part Number (conditional) --}}
                        @if (!empty($product->product_part_number))
                            <p class="details__brand"><strong>Part Number:</strong>
                                <span>
                                    <a href="javascript:void(0);">
                                        {{ $product->product_part_number }}
                                    </a>
                                </span>
                            </p>
                        @endif

                        {{-- Package (conditional) --}}
                        @if (!empty($product->package))
                            <p class="details__brand"><strong>Package:</strong>
                                <span>
                                    <a href="javascript:void(0);">
                                        {{ $product->package }}
                                    </a>
                                </span>
                            </p>
                        @endif

                        {{-- Date Code (conditional) --}}
                        @if (!empty($product->date_code))
                            <p class="details__brand"><strong>Date Code:</strong>
                                <span>
                                    <a href="javascript:void(0);">
                                        {{ $product->date_code }}
                                    </a>
                                </span>
                            </p>
                        @endif

                        {{-- Stock Status (always show) --}}
                        <p class="details__brand"><strong>Stock Status:</strong>
                            <span>
                                @if ($product->stock_status === 'in_stock')
                                    <span style="color: #28a745; font-weight: 600;">&#10003; In Stock</span>
                                @else
                                    <span style="color: #dc3545; font-weight: 600;">&#10007; Out of Stock</span>
                                @endif
                            </span>
                        </p>

                    </div>

                    <div class="product-details__content">

                        {{-- Specifications (conditional) --}}
                        @if ($product->specifications && $product->specifications->count() > 0)
                            <div class="product-spec-table" style="margin-top:20px;">
                                <h4 style="margin-bottom:12px;">Specifications</h4>
                                <div style="border:1px solid #e5e5e5; border-radius:8px; overflow:hidden;">
                                    <table style="width:100%; border-collapse:collapse;">
                                        <tbody>
                                            @foreach ($product->specifications as $spec)
                                                <tr>
                                                    <td class="col_one">{{ $spec->spec_key }}</td>
                                                    <td class="col_two">{{ $spec->spec_value }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                    </div>

                    {{-- Inquiry Button (conditional — only if in stock) --}}
                    @if ($product->stock_status === 'in_stock')
                        <div class="product-details__buttons">
                            <div class="product-details__buttons-2">
                                <button type="button" class="thm-btn" data-bs-toggle="modal" data-bs-target="#bulkOrderModal">
                                    Inquiry
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="product-details__buttons">
                            <div class="product-details__buttons-2">
                                <button type="button" class="thm-btn" disabled style="opacity: 0.5; cursor: not-allowed;" title="This product is currently out of stock">
                                    Out of Stock
                                </button>
                            </div>
                        </div>
                    @endif

                    {{-- Product Description (conditional) --}}
                    @if (!empty($product->product_description))
                        <section class="product-description">
                            <h3 class="product-description__title" style="text-decoration: underline; margin-bottom: 15px;">Description</h3>
                            <div class="product-description__text1" style="text-align: justify;">
                                {!! $product->product_description !!}
                            </div>
                        </section>
                    @endif

                </div>

            </div>
        </div>
    </section>

    {{-- Related Products --}}
    @if ($product->relatedProducts && $product->relatedProducts->count() > 0)
        <section class="services-two product">
            <div class="container">

                <div class="section-title section-title--two text-center">
                    <span class="section-title__tagline">Related Products</span>
                    {{-- <h2 class="section-title__title">Related Products</h2> --}}
                </div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="product__items">
                            <div class="product__all">
                                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-5 align-items-stretch">
                                    @foreach ($product->relatedProducts->take(5) as $item)
                                        <div class="col custom_product_margin">
                                            <div class="product__all-single h-100 d-flex flex-column">
                                                <a href="{{ route('product.details', $item->product_slug) }}">
                                                    <div class="product__all-img">
                                                        <img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}">
                                                    </div>
                                                </a>
                                                <div class="product__all-content text-center mt-auto">
                                                    <span class="product__category">
                                                        <a href="{{ route('product.by.brand', $item->brand->product_brand_slug ?? '#!') }}">{{ $item->brand->product_brand_name ?? '' }}</a>
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
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    @endif


    <!--=============== BULK ORDER POPUP ===============-->
    <div class="modal fade" id="bulkOrderModal" tabindex="-1" aria-labelledby="bulkOrderModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="bulkOrderModalLabel">Order Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="bulkOrderForm" action="{{ route('bulk.order.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="modal-body">
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
                        <button type="submit" class="thm-btn custom_thn_btn" id="bulkSubmitBtn">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!--=============== SCRIPTS ===============-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {

            toastr.options = {
                closeButton: true,
                progressBar: true,
                timeOut: 3500,
                positionClass: "toast-top-right"
            };

            $('#bulkOrderForm').submit(function(e) {
                e.preventDefault();

                const $form = $(this);
                const $btn = $('#bulkSubmitBtn');

                $btn.prop('disabled', true).text('Submitting...');

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        toastr.success(response.message || 'Order submitted successfully!');

                        const modalEl = document.getElementById('bulkOrderModal');
                        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                        modal.hide();

                        $form[0].reset();
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

@endsection
