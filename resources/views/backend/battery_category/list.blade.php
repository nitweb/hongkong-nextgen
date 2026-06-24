@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Battery Category List</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.battery_category.add') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-plus me-1"></i> Add Category
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
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $cat)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $cat->name }} <span class="badge text-bg-secondary">{{ $cat->products_count }}</span></td>
                                                <td><code>{{ $cat->slug }}</code></td>
                                                <td>
                                                    <span class="badge {{ $cat->status === 'active' ? 'text-bg-success' : 'text-bg-danger' }}">
                                                        {{ ucfirst($cat->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('backend.battery_category.edit', $cat->id) }}" class="btn btn-sm btn-outline-info mb-1">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <a href="{{ route('backend.battery_category.delete', $cat->id) }}" onclick="return confirm('Delete this category?')" class="btn btn-sm btn-outline-danger mb-1">
                                                        <i class="bx bxs-trash"></i>
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
