@extends('admin.dashboard')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Add Product</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.products.list') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-list-ul me-1"></i> Product List
                            </a>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark">
                                <i class="bx bx-undo me-1"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-4">

                            @include('widgets.errors')

                            <form action="{{ route('backend.products.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                                @csrf

                                {{-- ===== Excess Inventory ===== --}}
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="flashSaleCheck" name="is_flash_sale" value="1" {{ old('is_flash_sale') ? 'checked' : '' }}>
                                        <label class="form-check-label">Excess Inventory Product</label>
                                    </div>
                                </div>

                                <div id="flashSaleFields" style="display:none;" class="col-12">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Excel File (.xlsx, .xls, .csv)</label>
                                            <input type="file" name="flash_sale_excel" class="form-control" accept=".xlsx,.xls,.csv">
                                            <small class="text-muted">Max 10MB</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">PDF File</label>
                                            <input type="file" name="flash_sale_pdf" class="form-control" accept="application/pdf">
                                            <small class="text-muted">Max 5MB</small>
                                        </div>
                                    </div>
                                </div>

                                {{-- ===== IT Product ===== --}}
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="itProductCheck" name="is_it_product" value="1" {{ old('is_it_product') ? 'checked' : '' }}>
                                        <label class="form-check-label">IT Product</label>
                                    </div>
                                </div>

                                <div id="itCategoryField" style="display:none;" class="col-12">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">IT Product Category <span class="text-danger">*</span></label>
                                            <select name="it_category_id" class="form-select" id="itCategorySelect">
                                                <option value="" disabled selected>-- Select IT Category --</option>
                                                @foreach ($it_categories as $itCat)
                                                    <option value="{{ $itCat->id }}" {{ old('it_category_id') == $itCat->id ? 'selected' : '' }}>
                                                        {{ $itCat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- ===== Battery Product ===== --}}
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="batteryCheck" name="is_battery" value="1" {{ old('is_battery') ? 'checked' : '' }}>
                                        <label class="form-check-label">Battery Product</label>
                                    </div>
                                </div>

                                <div id="batteryFields" style="display:none;" class="col-12">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Battery Category <span class="text-danger">*</span></label>
                                            <select name="battery_category_id" class="form-select" id="batteryCategorySelect">
                                                <option value="" disabled selected>-- Select Battery Category --</option>
                                                @foreach ($battery_categories as $bCat)
                                                    <option value="{{ $bCat->id }}" {{ old('battery_category_id') == $bCat->id ? 'selected' : '' }}>
                                                        {{ $bCat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- ===== Main Image ===== --}}
                                <div class="col-md-12">
                                    <label class="form-label">Main Image (583 × 583)</label>
                                    <input type="file" name="product_image" class="form-control" id="image">
                                    <img id="showImage" src="{{ asset('upload/no_image.jpg') }}" class="mt-2 rounded" style="width:120px;height:120px;object-fit:cover;">
                                </div>

                                {{-- ===== Product Name ===== --}}
                                <div class="col-md-6">
                                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" name="product_name" class="form-control" value="{{ old('product_name') }}" required>
                                </div>

                                {{-- ===== Slug ===== --}}
                                <div class="col-md-6">
                                    <label class="form-label">Product Slug <span class="text-danger">*</span></label>
                                    <input type="text" name="product_slug" id="product_slug" class="form-control" value="{{ old('product_slug') }}" required>
                                </div>

                                {{-- ===== Normal Product Category ===== --}}
                                <div id="normalProductFields" class="col-12">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Category</label>
                                            <select name="product_category_id" class="form-select" id="categorySelect">
                                                <option value="" disabled selected>Select Category</option>
                                                @foreach ($categories as $cat)
                                                    <option value="{{ $cat->id }}" {{ old('product_category_id') == $cat->id ? 'selected' : '' }}>
                                                        {{ $cat->product_category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- ===== Brand ===== --}}
                                <div class="col-md-6">
                                    <label class="form-label">Brand <span class="text-danger">*</span></label>
                                    <select name="brand_id" class="form-select" id="brandSelect">
                                        <option value="" disabled selected>Select Brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->product_brand_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- ===== Part Number ===== --}}
                                <div class="col-md-6">
                                    <label class="form-label">Product Part Number</label>
                                    <input type="text" name="product_part_number" class="form-control" value="{{ old('product_part_number') }}">
                                </div>

                                {{-- ===== Package ===== --}}
                                <div class="col-md-6">
                                    <label class="form-label">Package</label>
                                    <input type="text" name="package" class="form-control" value="{{ old('package') }}">
                                </div>

                                {{-- ===== Date Code ===== --}}
                                <div class="col-md-6">
                                    <label class="form-label">Date Code</label>
                                    <input type="text" name="date_code" class="form-control" value="{{ old('date_code') }}">
                                </div>

                                {{-- ===== Specifications ===== --}}
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="form-label">Specifications</label>
                                        <button type="button" class="btn btn-sm btn-primary" id="addSpecBtn">+ Add</button>
                                    </div>
                                    <div id="specWrapper" class="mt-2">
                                        <div class="row specRow mb-2">
                                            <div class="col-md-4">
                                                <input type="text" name="spec_key[]" class="form-control" placeholder="Key">
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" name="spec_value[]" class="form-control" placeholder="Value">
                                            </div>
                                            <div class="col-md-1 d-grid">
                                                <button type="button" class="btn btn-danger btn-sm removeSpec">X</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- ===== Description ===== --}}
                                <div class="col-12">
                                    <label class="form-label">Product Description</label>
                                    <textarea name="product_description" class="form-control summernote">{{ old('product_description') }}</textarea>
                                </div>

                                {{-- ===== Stock Status ===== --}}
                                <div class="col-12">
                                    <label class="form-label d-block">Stock Status</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="stock_status" value="in_stock" checked>
                                        <label class="form-check-label">In Stock</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="stock_status" value="out_of_stock">
                                        <label class="form-check-label">Out of Stock</label>
                                    </div>
                                </div>

                                {{-- ===== Status ===== --}}
                                <div class="col-12">
                                    <label class="form-label d-block">Status</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="active" checked>
                                        <label class="form-check-label">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="inactive">
                                        <label class="form-check-label">Inactive</label>
                                    </div>
                                </div>

                                {{-- ===== Submit ===== --}}
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm">Create Product</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        $('#image').change(function(e) {
            let reader = new FileReader();
            reader.onload = e => $('#showImage').attr('src', e.target.result);
            reader.readAsDataURL(e.target.files[0]);
        });

        $('input[name="product_name"]').on('keyup', function() {
            let slug = $(this).val().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            $('#product_slug').val(slug);
        });

        $('#addSpecBtn').click(function() {
            $('#specWrapper').append(`
                <div class="row specRow mb-2">
                    <div class="col-md-4"><input type="text" name="spec_key[]" class="form-control" placeholder="Key"></div>
                    <div class="col-md-7"><input type="text" name="spec_value[]" class="form-control" placeholder="Value"></div>
                    <div class="col-md-1 d-grid"><button type="button" class="btn btn-danger btn-sm removeSpec">X</button></div>
                </div>
            `);
        });
        $(document).on('click', '.removeSpec', function() {
            $(this).closest('.specRow').remove();
        });

        function toggleFlashSaleFields() {
            $('#flashSaleCheck').is(':checked') ? $('#flashSaleFields').slideDown() : $('#flashSaleFields').slideUp();
        }
        toggleFlashSaleFields();
        $('#flashSaleCheck').on('change', toggleFlashSaleFields);

        function toggleItProductFields() {
            if ($('#itProductCheck').is(':checked')) {
                $('#normalProductFields').slideUp();
                $('#itCategoryField').slideDown();
                $('#categorySelect').removeAttr('required');
            } else {
                if (!$('#batteryCheck').is(':checked')) {
                    $('#normalProductFields').slideDown();
                    $('#categorySelect').attr('required', true);
                }
                $('#itCategoryField').slideUp();
            }
        }
        toggleItProductFields();

        function toggleBatteryFields() {
            if ($('#batteryCheck').is(':checked')) {
                $('#normalProductFields').slideUp();
                $('#batteryFields').slideDown();
                $('#categorySelect').removeAttr('required');
            } else {
                if (!$('#itProductCheck').is(':checked')) {
                    $('#normalProductFields').slideDown();
                    $('#categorySelect').attr('required', true);
                }
                $('#batteryFields').slideUp();
            }
        }
        toggleBatteryFields();

        $('#itProductCheck').on('change', function() {
            if ($(this).is(':checked')) {
                $('#batteryCheck').prop('checked', false);
                $('#batteryFields').slideUp();
            }
            toggleItProductFields();
        });
        $('#batteryCheck').on('change', function() {
            if ($(this).is(':checked')) {
                $('#itProductCheck').prop('checked', false);
                $('#itCategoryField').slideUp();
            }
            toggleBatteryFields();
        });
    </script>

    @include('admin.layout.custom_scripts')
@endsection
