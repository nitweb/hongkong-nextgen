@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="container-fluid">

            {{-- Breadcrumb  --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ $title }} Edit</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.product_brand.list') }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-list-ul font-size-16 align-middle me-2"></i> {{ $title }} List
                            </a>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark waves-effect waves-light">
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

                            <form class="row g-3" action="{{ route('backend.product_brand.update') }}" method="post" enctype="multipart/form-data">

                                @csrf

                                <input type="hidden" name="id" value="{{ $product_brand_info->id }}">

                                <div class="col-md-8">
                                    <label for="example-text-input" class="form-label">Image [440px by 440px]</label>
                                    <input type="file" class="form-control" name="product_brand_image" id="image">
                                    <img id="showImage" src="{{ !empty($product_brand_info->product_brand_image) ? url('upload/product_brand_image/' . $product_brand_info->product_brand_image) : url('upload/no_image.jpg') }}" alt="Product Category Image" class="p-1 bg-primary mt-3" style="width: 110px; height: 110px; object-fit: cover; border-radius: 8px;">
                                </div>

                                <div class="col-md-8">
                                    <label for="product_brand_name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="product_brand_name" name="product_brand_name" value="{{ $product_brand_info->product_brand_name }}" required>
                                </div>

                                <div class="col-md-8">
                                    <label for="product_brand_slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control" id="product_brand_slug" name="product_brand_slug" value="{{ $product_brand_info->product_brand_slug }}" required>
                                </div>


                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-primary">Update Brand</button>
                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            })
        })
    </script>
    @include('admin.layout.custom_scripts')

    {{-- Toastr Script --}}
@endsection
