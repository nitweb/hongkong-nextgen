@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Breadcrumb  --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Product Category List</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.product_categories.add') }}" class="btn btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-plus font-size-16 align-middle me-2"></i> Add Product Category
                            </a>
                            <a href="javascript:history.back()" class="btn btn-outline-dark waves-effect waves-light">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Custom Table --}}
            <div class="row">

                <div class="col-12">

                    <div class="card">

                        <div class="card-body">

                            <div class="table-responsive">

                                <table id="datatable-buttons" class="table table-bordered w-100">

                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Product Category Image</th>
                                            <th>Product Category Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($product_categories_list as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <img src="{{ !empty($item->product_category_image) ? url('upload/product_category_image/' . $item->product_category_image) : url('upload/no_image.jpg') }}" alt="Product Category Image" class="img-fluid d-block" style="width: 80px;">
                                                </td>
                                                <td>{{ $item->product_category_name }}</td>
                                                <td>
                                                    <span class="badge custom_status_badge {{ $item->product_category_status == 'active' ? 'text-bg-success' : 'text-bg-danger' }}" data-id="{{ $item->id }}" data-model="{{ \App\Models\ProductCategory::class }}">
                                                        {{ ucfirst($item->product_category_status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{-- Status Update --}}
                                                    <div class="btn-group" role="group" style="margin-top: -8px;">
                                                        <button type="button" class="btn btn-outline-secondary waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Status <i class="mdi mdi-chevron-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item js-update-status" href="javascript:void(0)" data-id="{{ $item->id }}" data-status="active" data-model="{{ \App\Models\ProductCategory::class }}" data-column="product_category_status">Active</a></li>
                                                            <li><a class="dropdown-item js-update-status" href="javascript:void(0)" data-id="{{ $item->id }}" data-status="inactive" data-model="{{ \App\Models\ProductCategory::class }}" data-column="product_category_status">Inactive</a></li>
                                                        </ul>
                                                    </div>
                                                    {{-- Edit btn --}}
                                                    <a href="{{ route('backend.product_categories.edit', $item->id) }}" class="btn btn-outline-info waves-effect waves-light mb-2">
                                                        <i class="bx bx-edit font-size-16 align-middle"></i>
                                                    </a>
                                                    {{-- Delete btn --}}
                                                    <a href="{{ route('backend.product_categories.delete', $item->id) }}" class="btn btn-outline-danger waves-effect waves-light mb-2" onclick="return confirm('Are you sure?')">
                                                        <i class="bx bxs-trash font-size-16 align-middle"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
