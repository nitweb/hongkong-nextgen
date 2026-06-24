@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Add Excess Inventory</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.excess_inventory.list') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-list-ul me-1"></i> List
                            </a>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark">
                                <i class="bx bx-undo me-1"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-4">
                            @include('widgets.errors')
                            <form action="{{ route('backend.excess_inventory.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                                @csrf

                                <div class="col-12">
                                    <label class="form-label">Particulars <span class="text-danger">*</span></label>
                                    <input type="text" name="particulars" class="form-control" value="{{ old('particulars') }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Excel File (.xlsx, .xls, .csv)</label>
                                    <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls,.csv">
                                    <small class="text-muted">Max 10MB</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">PDF File</label>
                                    <input type="file" name="pdf_file" class="form-control" accept="application/pdf">
                                    <small class="text-muted">Max 5MB</small>
                                </div>

                                <div class="col-12">
                                    <label class="form-label d-block">Status</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="active" checked>
                                        <label class="form-check-label">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="inactive">
                                        <label class="form-check-label">Inactive</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
