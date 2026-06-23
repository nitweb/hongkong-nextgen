@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Product List</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.products.add') }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-plus font-size-16 align-middle me-2"></i> Add Product
                            </a>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark waves-effect waves-light">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-bordered w-100">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Image</th>
                                            <th>Product Info</th>
                                            <th>Brand</th>
                                            <th>Stock</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product_list as $item)
                                            @php
                                                $img = !empty($item->product_image) ? (str_contains($item->product_image, '/') ? $item->product_image : 'upload/products/' . $item->product_image) : 'upload/no_image.jpg';
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>

                                                <td>
                                                    <img src="{{ asset($img) }}" alt="Product" class="img-fluid rounded" style="width:70px;height:70px;object-fit:cover;">
                                                </td>

                                                <td>
                                                    <p class="mb-1 fw-semibold" style="font-size:13px;">
                                                        {{ $item->product_name }}
                                                    </p>

                                                    {{-- Type Badge --}}
                                                    @if ($item->is_battery)
                                                        <span class="badge rounded-pill me-1" style="background:#FDE8F0;color:#8B0038;font-size:11px;font-weight:500;">
                                                            <i class="bx bx-battery me-1"></i>Battery
                                                        </span>
                                                        @if ($item->batteryCategory)
                                                            <span class="badge rounded-pill" style="background:#f9f0ff;color:#5b2d8e;font-size:11px;font-weight:500;">
                                                                {{ $item->batteryCategory->name }}
                                                            </span>
                                                        @endif
                                                    @elseif ($item->is_it_product)
                                                        <span class="badge rounded-pill me-1" style="background:#E6F1FB;color:#0C447C;font-size:11px;font-weight:500;">
                                                            <i class="bx bx-chip me-1"></i>IT Product
                                                        </span>
                                                        @if ($item->itCategory)
                                                            <span class="badge rounded-pill" style="background:#f0f4ff;color:#3b4a6b;font-size:11px;font-weight:500;">
                                                                {{ $item->itCategory->name }}
                                                            </span>
                                                        @endif
                                                    @elseif ($item->is_flash_sale)
                                                        <span class="badge rounded-pill" style="background:#FAEEDA;color:#633806;font-size:11px;font-weight:500;">
                                                            <i class="bx bx-layer me-1"></i>Excess Inventory
                                                        </span>
                                                    @else
                                                        <span class="badge rounded-pill" style="background:#EAF3DE;color:#27500A;font-size:11px;font-weight:500;">
                                                            <i class="bx bx-box me-1"></i>Normal Product
                                                        </span>
                                                    @endif

                                                    {{-- Category (normal product only) --}}
                                                    @if (!$item->is_it_product && !$item->is_battery && $item->category)
                                                        <div class="mt-1">
                                                            <small class="text-muted">
                                                                <i class="bx bx-category-alt me-1"></i>{{ $item->category->product_category_name }}
                                                            </small>
                                                        </div>
                                                    @endif
                                                </td>

                                                <td>{{ $item->brand->product_brand_name ?? '-' }}</td>

                                                <td>
                                                    <span class="badge {{ $item->stock_status === 'in_stock' ? 'text-bg-success' : 'text-bg-danger' }}">
                                                        {{ $item->stock_status === 'in_stock' ? 'In Stock' : 'Stock Out' }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="badge custom_status_badge {{ $item->status == 'active' ? 'text-bg-success' : 'text-bg-danger' }}" data-id="{{ $item->id }}" data-model="{{ \App\Models\Product::class }}">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <div class="btn-group" role="group" style="margin-top:-8px;">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Status <i class="mdi mdi-chevron-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item js-update-status" href="javascript:void(0)" data-id="{{ $item->id }}" data-status="active" data-model="{{ \App\Models\Product::class }}" data-column="status">Active</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item js-update-status" href="javascript:void(0)" data-id="{{ $item->id }}" data-status="inactive" data-model="{{ \App\Models\Product::class }}" data-column="status">Inactive</a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <a href="{{ route('backend.products.edit', $item->id) }}" class="btn btn-sm btn-outline-info waves-effect waves-light mb-2">
                                                        <i class="bx bx-edit font-size-16 align-middle"></i>
                                                    </a>

                                                    <a href="{{ route('backend.products.delete', $item->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-outline-danger waves-effect waves-light mb-2">
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
