@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Excess Inventory List</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.excess_inventory.add') }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-plus font-size-16 align-middle me-2"></i> Add
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
                                            <th>Particulars</th>
                                            <th>Excel</th>
                                            <th>PDF</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($list as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->particulars }}</td>
                                                <td>
                                                    @if ($item->excel_file)
                                                        <a href="{{ asset($item->excel_file) }}" download class="btn btn-xs btn-outline-success btn-sm">
                                                            <i class="bx bx-spreadsheet"></i> Download
                                                        </a>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->pdf_file)
                                                        <a href="{{ asset($item->pdf_file) }}" target="_blank" class="btn btn-xs btn-outline-danger btn-sm">
                                                            <i class="bx bxs-file-pdf"></i> View
                                                        </a>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge custom_status_badge {{ $item->status == 'active' ? 'text-bg-success' : 'text-bg-danger' }}" data-id="{{ $item->id }}" data-model="{{ \App\Models\ExcessInventory::class }}">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group" style="margin-top:-8px;">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                            Status <i class="mdi mdi-chevron-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item js-update-status" href="javascript:void(0)" data-id="{{ $item->id }}" data-status="active" data-model="{{ \App\Models\ExcessInventory::class }}" data-column="status">Active</a></li>
                                                            <li><a class="dropdown-item js-update-status" href="javascript:void(0)" data-id="{{ $item->id }}" data-status="inactive" data-model="{{ \App\Models\ExcessInventory::class }}" data-column="status">Inactive</a></li>
                                                        </ul>
                                                    </div>
                                                    <a href="{{ route('backend.excess_inventory.edit', $item->id) }}" class="btn btn-sm btn-outline-info mb-2">
                                                        <i class="bx bx-edit font-size-16 align-middle"></i>
                                                    </a>
                                                    <a href="{{ route('backend.excess_inventory.delete', $item->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-outline-danger mb-2">
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
