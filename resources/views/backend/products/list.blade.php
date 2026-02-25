@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Breadcrumb  --}}
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
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            {{-- <th>Price</th> --}}
                                            <th>Stock</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($product_list as $item)
                                            @php
                                                // product_image যদি full path হিসেবে save করা থাকে (upload/products/xxx.jpg)
                                                // বা শুধু filename হলেও handle করবে
                                                $img = !empty($item->product_image) ? (str_contains($item->product_image, '/') ? $item->product_image : 'upload/products/' . $item->product_image) : 'upload/no_image.jpg';

                                                $finalPrice = $item->discount_price ?? $item->product_price;
                                            @endphp

                                            <tr>
                                                <td>{{ $loop->iteration }}</td>

                                                <td>
                                                    <img src="{{ asset($img) }}" alt="Product Image" class="img-fluid d-block" style="width:80px;height:80px;object-fit:cover;">
                                                </td>

                                                <td>{{ $item->product_name }}</td>

                                                <td>{{ $item->category->product_category_name ?? '-' }}</td>

                                                <td>{{ $item->brand->product_brand_name ?? '-' }}</td>

                                                {{-- <td>
                                                    @if (!is_null($item->discount_price))
                                                        <div>
                                                            <span class="fw-semibold">${{ number_format($item->discount_price, 2) }}</span>
                                                            <del class="text-muted ms-1">${{ number_format($item->product_price, 2) }}</del>
                                                        </div>
                                                    @else
                                                        ${{ number_format($item->product_price, 2) }}
                                                    @endif
                                                </td> --}}

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
                                                    {{-- Status Update --}}
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

                                                    {{-- Edit --}}
                                                    <a href="{{ route('backend.products.edit', $item->id) }}" class="btn btn-sm btn-outline-info waves-effect waves-light mb-2">
                                                        <i class="bx bx-edit font-size-16 align-middle"></i>
                                                    </a>

                                                    {{-- Delete --}}
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
