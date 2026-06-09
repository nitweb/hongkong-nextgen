@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Add IT Product Category</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.it_categories.list') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-list-ul me-1"></i> IT Product Category List
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

                            <form action="{{ route('backend.it_categories.store') }}" method="POST" class="row g-3">
                                @csrf

                                <div class="col-12">
                                    <label class="form-label">Category Name</label>
                                    <input type="text" name="name" id="cat_name" class="form-control" value="{{ old('name') }}" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Slug</label>
                                    <input type="text" name="slug" id="cat_slug" class="form-control" value="{{ old('slug') }}" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label d-block">Status</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="active" {{ old('status', 'active') === 'active' ? 'checked' : '' }}>
                                        <label class="form-check-label">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="inactive" {{ old('status') === 'inactive' ? 'checked' : '' }}>
                                        <label class="form-check-label">Inactive</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm">Create IT Product Category</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('cat_name').addEventListener('keyup', function() {
            let slug = this.value.toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '');
            document.getElementById('cat_slug').value = slug;
        });
    </script>

    @include('admin.layout.custom_scripts')
@endsection
