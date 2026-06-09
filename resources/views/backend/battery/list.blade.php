@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Battery List</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.battery.add') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-plus me-1"></i> Add Battery
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
                                            <th>Thumbnail</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($modules as $module)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @if ($module->thumbnail)
                                                        <img src="{{ asset($module->thumbnail) }}" style="width:70px;height:50px;object-fit:cover;border-radius:6px;">
                                                    @else
                                                        <div style="width:70px;height:50px;background:#f0f0f0;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                                                            <i class="bx bx-spreadsheet text-muted" style="font-size:22px;"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <p class="mb-0 fw-semibold">{{ $module->title }}</p>
                                                    @if ($module->description)
                                                        <small class="text-muted">{{ Str::limit($module->description, 60) }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($module->category)
                                                        <span class="badge rounded-pill" style="background:#E6F1FB;color:#0C447C;">
                                                            {{ $module->category }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge {{ $module->status === 'active' ? 'text-bg-success' : 'text-bg-danger' }}">
                                                        {{ ucfirst($module->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('backend.battery.edit', $module->id) }}" class="btn btn-sm btn-outline-info mb-1">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <a href="{{ route('backend.battery.delete', $module->id) }}" onclick="return confirm('Delete this module?')" class="btn btn-sm btn-outline-danger mb-1">
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
