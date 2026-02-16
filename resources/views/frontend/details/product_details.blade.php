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

                <div class="col-lg-6 col-xl-6">
                    <div class="product-details__img">
                        <img src="{{ asset('upload/product_image/' . $product->product_image) }}" alt="{{ $product->product_name }}" />
                    </div>
                </div>

                <div class="col-lg-6 col-xl-6">

                    <div class="product-details__top">
                        <h3 class="product-details__title">
                            {{ $product->product_name }}
                            {{-- <br> --}}
                            <div style="margin-top: -15px;">
                                <span>${{ number_format($product->product_price - ($product->discount_price ?? 0), 2) }}</span>
                                @if ($product->discount_price > 0)
                                    <span class="old__price">
                                        ${{ number_format($product->product_price, 2) }}
                                    </span>
                                @endif
                            </div>
                        </h3>
                    </div>

                    <div class="product-details__reveiw">
                        <p class="details__brand"><strong>Category:</strong>
                            <span>
                                <a href="{{ route('product.by.category', $product->category->product_category_slug ?? '#') }}">
                                    {{ $product->category->product_category_name ?? 'N/A' }}
                                </a>
                            </span>
                        </p>
                    </div>

                    <div class="product-details__content">
                        {{-- <div class="product-details__content-text1" style="text-align: justify;">
                            {{ $product->product_short_description }}
                        </div> --}}

                        {{-- <p class="product-details__content-text2">REF. 4231/406 <br>
                            Available in store</p> --}}

                        @if ($product->specifications && $product->specifications->count() > 0)
                            <div class="product-spec-table" style="margin-top:20px;">
                                <h4 style="margin-bottom:12px;">Specifications</h4>

                                <div style="border:1px solid #e5e5e5; border-radius:8px; overflow:hidden;">
                                    <table style="width:100%; border-collapse:collapse;">
                                        <tbody>
                                            <tr>
                                                <td class="col_one">Product Part Number</td>
                                                <td class="col_two">{{ $product->product_part_number }}</td>
                                            </tr>
                                            <tr>
                                                <td class="col_one">Brand Name</td>
                                                <td class="col_two">{{ $product->brand_name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="col_one">Package</td>
                                                <td class="col_two">{{ $product->package }}</td>
                                            </tr>
                                            <tr>
                                                <td class="col_one">Date Code</td>
                                                <td class="col_two">{{ $product->date_code }}</td>
                                            </tr>
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

                    <div class="product-details__buttons">
                        {{-- ✅ Bulk Order Button (Bootstrap modal open) --}}
                        <div class="product-details__buttons-2">
                            <button type="button" class="thm-btn" data-bs-toggle="modal" data-bs-target="#bulkOrderModal">
                                Inquiry
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- Product Description --}}
    <section class="product-description">
        <div class="container">
            <h3 class="product-description__title">Description</h3>
            <div class="product-description__text1" style="text-align: justify;">
                {!! $product->product_description !!}
            </div>
        </div>
    </section>

    <!--=============== BULK ORDER POPUP (Bootstrap Modal - Medium) ===============-->
    <div class="modal fade" id="bulkOrderModal" tabindex="-1" aria-labelledby="bulkOrderModalLabel" aria-hidden="true">
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
                        <button type="submit" class="btn btn-primary" id="bulkSubmitBtn">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <!--=============== (Optional) Bootstrap CSS/JS if not in master layout ===============-->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}


    <!--=============== SCRIPTS ===============-->
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

            // ✅ AJAX submit (Bootstrap modal)
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
                        toastr.success(response.message || 'Bulk order submitted successfully!');

                        // close modal (Bootstrap 5)
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
