@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Add Battery</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.battery.list') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-list-ul me-1"></i> Battery List
                            </a>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark waves-effect waves-light">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
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
                            <form action="{{ route('backend.battery.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                                @csrf

                                <div class="col-md-12">
                                    <label class="form-label">Thumbnail Image</label>
                                    <input type="file" name="thumbnail" class="form-control" accept="image/*" id="thumbInput">
                                    <img id="thumbPreview" src="{{ asset('upload/no_image.jpg') }}" class="mt-2 rounded" style="width:120px;height:80px;object-fit:cover;">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Category</label>
                                    <input type="text" name="category" id="categoryInput" class="form-control" value="{{ old('category') }}" placeholder="e.g. Li-Ion, Lead Acid" autocomplete="off" list="categoryDatalist">

                                    <datalist id="categoryDatalist">
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat }}">
                                        @endforeach
                                    </datalist>

                                    @if ($categories->count())
                                        <div class="mt-2 d-flex flex-wrap gap-1">
                                            @foreach ($categories as $cat)
                                                <span class="badge border" style="background:#E6F1FB;color:#0C447C;cursor:pointer;font-size:11px;" onclick="document.getElementById('categoryInput').value='{{ $cat }}'">
                                                    {{ $cat }}
                                                </span>
                                            @endforeach
                                        </div>
                                        <small class="text-muted">👆 Click to reuse existing category</small>
                                    @endif
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Short description...">{{ old('description') }}</textarea>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Excel File <span class="text-danger">*</span></label>
                                    <input type="file" name="file_path" class="form-control" accept=".xlsx,.xls,.csv" required>
                                    <small class="text-muted">Allowed: .xlsx, .xls, .csv — Max 10MB</small>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm">Create Battery</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        $('#thumbInput').change(function(e) {
            let reader = new FileReader();
            reader.onload = e => $('#thumbPreview').attr('src', e.target.result);
            reader.readAsDataURL(e.target.files[0]);
        });
    </script>
    @include('admin.layout.custom_scripts')
@endsection
