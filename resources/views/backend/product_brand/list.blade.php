@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Breadcrumb  --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ $title }} List</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.product_brand.add') }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-plus font-size-16 align-middle me-2"></i> Add {{ $title }}
                            </a>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark waves-effect waves-light">
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
                                            <th>Brand Image</th>
                                            <th>Brand Name</th>
                                            <th>Brand Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($product_brand_list as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <img src="{{ !empty($item->product_brand_image) ? url('upload/product_brand_image/' . $item->product_brand_image) : url('upload/no_image.jpg') }}" alt="Product Brand Image" class="img-fluid d-block" style="width: 80px;">
                                                </td>
                                                <td>{{ $item->product_brand_name }} <span class="badge text-bg-secondary">{{ $item->products_count }}</span></td>
                                                <td>
                                                    <span class="badge custom_status_badge {{ $item->product_brand_status == 'active' ? 'text-bg-success' : 'text-bg-danger' }}" data-id="{{ $item->id }}" data-model="{{ \App\Models\ProductBrand::class }}">
                                                        {{ ucfirst($item->product_brand_status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{-- Status Update --}}
                                                    <div class="btn-group" role="group" style="margin-top: -8px;">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Status <i class="mdi mdi-chevron-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item js-update-status" href="javascript:void(0)" data-id="{{ $item->id }}" data-status="active" data-model="{{ \App\Models\ProductBrand::class }}" data-column="product_brand_status">Active</a></li>
                                                            <li><a class="dropdown-item js-update-status" href="javascript:void(0)" data-id="{{ $item->id }}" data-status="inactive" data-model="{{ \App\Models\ProductBrand::class }}" data-column="product_brand_status">Inactive</a></li>
                                                        </ul>
                                                    </div>
                                                    {{-- Edit btn --}}
                                                    <a href="{{ route('backend.product_brand.edit', $item->id) }}" class="btn btn-sm btn-outline-info waves-effect waves-light mb-2">
                                                        <i class="bx bx-edit font-size-16 align-middle"></i>
                                                    </a>
                                                    {{-- Delete btn --}}
                                                    <a href="{{ route('backend.product_brand.delete', $item->id) }}" class="btn btn-sm btn-outline-danger waves-effect waves-light mb-2" onclick="return confirm('Are you sure?')">
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
