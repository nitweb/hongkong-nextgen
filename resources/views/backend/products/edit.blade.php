@extends('admin.dashboard')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Breadcrumb --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Edit Product</h4>
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

            {{-- Form --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-4">

                            @include('widgets.errors')

                            <form action="{{ route('backend.products.update') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product_info->id }}">

                                {{-- Category --}}
                                <div class="col-md-6">
                                    <label class="form-label">Category</label>
                                    <select name="product_category_id" class="form-select" required>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('product_category_id', $product_info->product_category_id) == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->product_category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Brand --}}
                                <div class="col-md-6">
                                    <label class="form-label">Brand</label>
                                    <select name="brand_id" class="form-select" required>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id', $product_info->brand_id) == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->product_brand_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Main Image --}}
                                <div class="col-md-12">
                                    <label class="form-label">Main Image (583 × 583)</label>
                                    <input type="file" name="product_image" class="form-control" id="image">

                                    @php
                                        $img = $product_info->product_image ? $product_info->product_image : 'upload/no_image.jpg';
                                    @endphp

                                    <img id="showImage" src="{{ asset($img) }}" class="mt-2 rounded" style="width:120px;height:120px;object-fit:cover;">
                                </div>

                                {{-- Add New Gallery Images --}}
                                <div class="col-md-12">
                                    <label class="form-label">Add New Gallery Images</label>
                                    <input type="file" name="product_gallery_images[]" class="form-control" multiple>
                                </div>

                                {{-- Product Name --}}
                                <div class="col-md-6">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" name="product_name" class="form-control" value="{{ old('product_name', $product_info->product_name) }}" required>
                                </div>

                                {{-- Slug --}}
                                <div class="col-md-6">
                                    <label class="form-label">Product Slug</label>
                                    <input type="text" name="product_slug" class="form-control" value="{{ old('product_slug', $product_info->product_slug) }}" required>
                                </div>

                                {{-- Price --}}
                                <div class="col-md-6">
                                    <label class="form-label">Price</label>
                                    <input type="number" step="0.01" min="0" name="product_price" class="form-control" value="{{ old('product_price', $product_info->product_price) }}" required>
                                </div>

                                {{-- Discount --}}
                                <div class="col-md-6">
                                    <label class="form-label">Discount Price</label>
                                    <input type="number" step="0.01" min="0" name="discount_price" class="form-control" value="{{ old('discount_price', $product_info->discount_price) }}">
                                </div>

                                {{-- Part Number --}}
                                <div class="col-md-6">
                                    <label class="form-label">Product Part Number</label>
                                    <input type="text" name="product_part_number" class="form-control" value="{{ old('product_part_number', $product_info->product_part_number) }}" required>
                                </div>

                                {{-- Package --}}
                                <div class="col-md-6">
                                    <label class="form-label">Package</label>
                                    <input type="text" name="package" class="form-control" value="{{ old('package', $product_info->package) }}" required>
                                </div>

                                {{-- Date Code --}}
                                <div class="col-md-6">
                                    <label class="form-label">Date Code</label>
                                    <input type="text" name="date_code" class="form-control" value="{{ old('date_code', $product_info->date_code) }}" required>
                                </div>

                                {{-- Description --}}
                                <div class="col-12">
                                    <label class="form-label">Product Description</label>
                                    <textarea name="product_description" class="form-control summernote">
{{ old('product_description', $product_info->product_description) }}
                                </textarea>
                                </div>

                                {{-- Specifications --}}
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="form-label">Specifications</label>
                                        <button type="button" id="addSpecBtn" class="btn btn-sm btn-primary">+ Add</button>
                                    </div>

                                    <div id="specWrapper" class="mt-2">
                                        @foreach ($product_info->specifications as $spec)
                                            <div class="row specRow mb-2">
                                                <div class="col-md-4">
                                                    <input type="text" name="spec_key[]" class="form-control" value="{{ $spec->spec_key }}">
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" name="spec_value[]" class="form-control" value="{{ $spec->spec_value }}">
                                                </div>
                                                <div class="col-md-1 d-grid">
                                                    <button type="button" class="btn btn-danger btn-sm removeSpec">X</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Flash Sale --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_flash_sale" value="1" {{ old('is_flash_sale', $product_info->is_flash_sale) ? 'checked' : '' }}>
                                    <label class="form-check-label">Flash Sale Product</label>
                                </div>

                                {{-- IT Product --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_it_product" value="1" {{ old('is_it_product', $product_info->is_it_product) ? 'checked' : '' }}>
                                    <label class="form-check-label">IT Product</label>
                                </div>

                                {{-- Stock Status --}}
                                <div class="col-12">
                                    <label class="form-label d-block">Stock Status</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="stock_status" value="in_stock" {{ old('stock_status', $product_info->stock_status) == 'in_stock' ? 'checked' : '' }}>
                                        <label class="form-check-label">In Stock</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="stock_status" value="out_of_stock" {{ old('stock_status', $product_info->stock_status) == 'out_of_stock' ? 'checked' : '' }}>
                                        <label class="form-check-label">Out of Stock</label>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="col-12">
                                    <label class="form-label d-block">Status</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="active" {{ old('status', $product_info->status) == 'active' ? 'checked' : '' }}>
                                        <label class="form-check-label">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="inactive" {{ old('status', $product_info->status) == 'inactive' ? 'checked' : '' }}>
                                        <label class="form-check-label">Inactive</label>
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Update Product
                                    </button>
                                </div>

                            </form>

                            {{-- Existing Gallery --}}
                            @if ($product_info->galleries->count() > 0)
                                <hr>
                                <h5>Gallery Images</h5>
                                <div class="row">
                                    @foreach ($product_info->galleries as $gallery)
                                        <div class="col-md-2 mb-3 text-center">
                                            <img src="{{ asset('upload/product_gallery/' . $gallery->product_gallery_image) }}" class="img-thumbnail mb-2" style="height:120px;object-fit:cover;">

                                            <form action="{{ route('backend.product.gallery.delete', $gallery->id) }}" method="POST" onsubmit="return confirm('Delete this image?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm w-100">Delete</button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Scripts --}}
    <script>
        // main image preview
        $('#image').change(function(e) {
            let reader = new FileReader();
            reader.onload = e => $('#showImage').attr('src', e.target.result);
            reader.readAsDataURL(e.target.files[0]);
        });

        // add spec
        $('#addSpecBtn').click(function() {
            $('#specWrapper').append(`
            <div class="row specRow mb-2">
                <div class="col-md-4">
                    <input type="text" name="spec_key[]" class="form-control">
                </div>
                <div class="col-md-7">
                    <input type="text" name="spec_value[]" class="form-control">
                </div>
                <div class="col-md-1 d-grid">
                    <button type="button" class="btn btn-danger btn-sm removeSpec">X</button>
                </div>
            </div>
        `);
        });

        $(document).on('click', '.removeSpec', function() {
            $(this).closest('.specRow').remove();
        });
    </script>

    @include('admin.layout.custom_scripts')
@endsection
