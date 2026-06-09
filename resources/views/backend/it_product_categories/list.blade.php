@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">IT Product Category List</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.it_categories.add') }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-plus font-size-16 align-middle me-2"></i> Add IT Product Category
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
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($list as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->slug }}</td>
                                                <td>
                                                    <span class="badge {{ $item->status === 'active' ? 'text-bg-success' : 'text-bg-danger' }}">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('backend.it_categories.edit', $item->id) }}" class="btn btn-sm btn-outline-info waves-effect waves-light">
                                                        <i class="bx bx-edit font-size-16 align-middle"></i>
                                                    </a>
                                                    <a href="{{ route('backend.it_categories.delete', $item->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-outline-danger waves-effect waves-light">
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
