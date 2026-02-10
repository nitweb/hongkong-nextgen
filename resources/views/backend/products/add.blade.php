@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Breadcrumb --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Product Add</h4>
                        <div class="page-title-right">
                            <a href="javascript:history.back()" class="btn btn-outline-dark">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Custom Form --}}
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body p-4">

                            @include('widgets.errors')

                            <form class="row g-3" action="{{ route('backend.products.store') }}" method="post" enctype="multipart/form-data" novalidate>
                                @csrf

                                {{-- Category --}}
                                <div class="col-md-8">
                                    <label class="form-label">Category</label>
                                    <select name="product_category_id" id="product_category_id" class="form-select" required>
                                        <option value="" selected disabled>Select Category</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->product_category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Subcategory (AJAX) --}}
                                <div class="col-md-8" id="subcategoryDiv" style="display:none;">
                                    <label class="form-label">SubCategory (optional)</label>
                                    <select name="product_sub_category_id" id="product_sub_category_id" class="form-select">
                                        <option value="">Select SubCategory</option>
                                    </select>
                                </div>

                                {{-- Shop By Age --}}
                                <div class="col-md-8">
                                    <label class="form-label">Age Group</label>
                                    <select name="age_group_id" class="form-select" required>
                                        <option value="" selected disabled>Select Age</option>
                                        @foreach ($ageGroups as $age)
                                            <option value="{{ $age->id }}">
                                                {{ $age->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Main Product Image --}}
                                <div class="col-md-8">
                                    <label class="form-label">Main Image [583px × 583px]</label>
                                    <input type="file" class="form-control" name="product_image" id="image">
                                    <img id="showImage" src="{{ asset('upload/no_image.jpg') }}" class="p-1 bg-primary mt-3" style="width:110px;height:110px;object-fit:cover;border-radius:8px;">
                                </div>

                                {{-- Gallery Images --}}
                                <div class="col-md-8">
                                    <label class="form-label">Product Gallery Images [Multiple]</label>
                                    <input type="file" class="form-control" name="product_gallery_images[]" id="gallery_images" multiple>
                                    <div id="galleryPreview" class="mt-3 d-flex flex-wrap gap-2"></div>
                                </div>

                                {{-- Product Name --}}
                                <div class="col-md-8">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" class="form-control" name="product_name" value="{{ old('product_name') }}" required>
                                </div>

                                {{-- Slug --}}
                                <div class="col-md-8">
                                    <label class="form-label">Product Slug</label>
                                    <input type="text" class="form-control" name="product_slug" value="{{ old('product_slug') }}" required>
                                </div>

                                {{-- Price --}}
                                <div class="col-md-8">
                                    <label class="form-label">Price ($)</label>
                                    <input type="number" step="0.01" min="0" class="form-control" name="product_price" value="{{ old('product_price') }}" required>
                                </div>

                                {{-- Discount Price --}}
                                <div class="col-md-8">
                                    <label class="form-label">Discount Price ($)</label>
                                    <input type="number" step="0.01" min="0" class="form-control" name="discount_price" value="{{ old('discount_price') }}">
                                </div>

                                {{-- Short Description --}}
                                <div class="col-md-8">
                                    <label class="form-label">Short Description</label>
                                    <textarea class="form-control" name="product_short_description" rows="4">{{ old('product_short_description') }}</textarea>
                                </div>

                                {{-- Long Description --}}
                                <div class="col-12">
                                    <label class="form-label">Product Description</label>
                                    <textarea class="form-control summernote" name="product_description">{{ old('product_description') }}</textarea>
                                </div>

                                {{-- ✅ Product Specification Table (Required) --}}
                                <div class="col-12">

                                    <label class="form-label">Product Specification Table (Required)</label>

                                    <div class="row g-2">

                                        <div class="col-md-6">
                                            <label class="form-label">Product Part Number</label>
                                            <input type="text" name="product_part_number" class="form-control" value="{{ old('product_part_number') }}" placeholder="e.g. XC4052XL-1HQ304C">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Brand Name</label>
                                            <select name="brand_name" class="form-select">
                                                <option value="" selected disabled>Select Brand</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->product_brand_name }}" {{ old('brand_name') == $brand->product_brand_name ? 'selected' : '' }}>
                                                        {{ $brand->product_brand_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="col-md-6">
                                            <label class="form-label">Package</label>
                                            <input type="text" name="package" class="form-control" value="{{ old('package') }}" placeholder="e.g. 304-BFQFP Exposed Pad">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Date Code</label>
                                            <input type="text" name="date_code" class="form-control" value="{{ old('date_code') }}" placeholder="e.g. 2407 / 2024-07 / any format">
                                        </div>

                                    </div>

                                </div>

                                {{-- ✅ NEW: Product Specification Table (Multiple) --}}
                                <div class="col-12">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <label class="form-label mb-0">Product Specification Table (Multiple)</label>
                                        <button type="button" id="addSpecBtn" class="btn btn-sm btn-primary">
                                            + Add More
                                        </button>
                                    </div>

                                    <div id="specWrapper" class="mt-3">
                                        @php
                                            $oldKeys = old('spec_key', []);
                                            $oldVals = old('spec_value', []);
                                        @endphp

                                        @if (count($oldKeys) > 0)
                                            @foreach ($oldKeys as $i => $k)
                                                <div class="row specRow mb-2">
                                                    <div class="col-md-4">
                                                        <input type="text" name="spec_key[]" class="form-control" value="{{ $k }}" placeholder="Key (e.g. PartNo)">
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="text" name="spec_value[]" class="form-control" value="{{ $oldVals[$i] ?? '' }}" placeholder="Value (e.g. XC4052XL-1HQ304C)">
                                                    </div>
                                                    <div class="col-md-1 d-grid">
                                                        <button type="button" class="btn btn-danger removeSpec">X</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="row specRow mb-2">
                                                <div class="col-md-4">
                                                    <input type="text" name="spec_key[]" class="form-control" placeholder="Key (e.g. PartNo)">
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="spec_value[]" class="form-control" placeholder="Value (e.g. XC4052XL-1HQ304C)">
                                                </div>
                                                <div class="col-md-1 d-grid">
                                                    <button type="button" class="btn btn-danger removeSpec">X</button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- (Optional) old textarea keep --}}
                                <div class="col-12">
                                    <label class="form-label">Product Specifications (HTML - Optional)</label>
                                    <textarea class="form-control summernote" name="product_specifications">{{ old('product_specifications') }}</textarea>
                                </div>

                                <div class="col-8">
                                    <label class="form-label">Test Report (ASTM)</label>
                                    <input type="file" name="test_report_astm" class="form-control" accept=".pdf,.doc,.docx">
                                </div>

                                <div class="col-8">
                                    <label class="form-label">Test Report (EN71)</label>
                                    <input type="file" name="test_report_en71" class="form-control" accept=".pdf,.doc,.docx">
                                </div>

                                <div>Do you want this product to be available for wholesale?</div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="is_wholesale" value="1" id="is_wholesale" {{ old('is_wholesale') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_wholesale">
                                        Wholesale Product
                                    </label>
                                </div>

                                <div>Do you want to offer free delivery for this product?</div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="is_free_delivery" value="1" id="is_free_delivery" {{ old('is_free_delivery') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_free_delivery">
                                        Free Delivery
                                    </label>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label d-block">Product Stock Status</label>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="stock_status" id="in_stock" value="in_stock" {{ old('stock_status', 'in_stock') == 'in_stock' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="in_stock">
                                            In Stock
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="stock_status" id="out_of_stock" value="out_of_stock" {{ old('stock_status') == 'out_of_stock' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="out_of_stock">
                                            Stock Out
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- Preview + AJAX Script --}}
    <script>
        $(document).ready(function() {

            // Main Image preview
            $('#image').change(function(e) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            });

            // Gallery Images preview
            $('#gallery_images').on('change', function() {
                $('#galleryPreview').html('');
                let files = $(this)[0].files;

                if (files.length > 0) {
                    for (let i = 0; i < files.length; i++) {
                        let file = files[i];
                        let reader = new FileReader();

                        reader.onload = function(e) {
                            let img = $('<img>').attr('src', e.target.result)
                                .css({
                                    width: '100px',
                                    height: '100px',
                                    'object-fit': 'cover',
                                    'border-radius': '8px',
                                    'border': '1px solid #ddd',
                                    'padding': '2px'
                                });
                            $('#galleryPreview').append(img);
                        }
                        reader.readAsDataURL(file);
                    }
                }
            });

            // Load sub category via AJAX
            $('#product_category_id').on('change', function() {
                let category_id = $(this).val();

                if (!category_id) {
                    $('#subcategoryDiv').hide();
                    return;
                }

                $.ajax({
                    url: "{{ route('backend.product_subcategories.by.category') }}",
                    type: "GET",
                    data: {
                        category_id: category_id
                    },
                    success: function(res) {
                        if (res.length > 0) {
                            $('#subcategoryDiv').show();
                            let html = '<option value="">Select SubCategory</option>';

                            $.each(res, function(key, val) {
                                html += `<option value="${val.id}">${val.product_sub_category_name}</option>`;
                            });

                            $('#product_sub_category_id').html(html);
                        } else {
                            $('#subcategoryDiv').hide();
                        }
                    }
                });
            });

            // ✅ Spec Row Add
            $('#addSpecBtn').on('click', function() {
                let row = `
                    <div class="row specRow mb-2">
                        <div class="col-md-4">
                            <input type="text" name="spec_key[]" class="form-control" placeholder="Key (e.g. Voltage)">
                        </div>
                        <div class="col-md-7">
                            <input type="text" name="spec_value[]" class="form-control" placeholder="Value (e.g. 3V ~ 3.6V)">
                        </div>
                        <div class="col-md-1 d-grid">
                            <button type="button" class="btn btn-danger removeSpec">X</button>
                        </div>
                    </div>
                `;
                $('#specWrapper').append(row);
            });

            // ✅ Spec Row Remove
            $(document).on('click', '.removeSpec', function() {
                $(this).closest('.specRow').remove();
            });

        });
    </script>

    @include('admin.layout.custom_scripts')
@endsection
