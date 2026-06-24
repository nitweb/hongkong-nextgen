@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Edit YouTube Video</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.youtube_video.list') }}" class="btn btn-sm btn-outline-primary">
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
                            <form action="{{ route('backend.youtube_video.update') }}" method="POST" class="row g-3">
                                @csrf
                                <input type="hidden" name="id" value="{{ $info->id }}">

                                <div class="col-12">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title', $info->title) }}">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">YouTube URL <span class="text-danger">*</span></label>
                                    <input type="url" name="youtube_url" class="form-control" value="{{ old('youtube_url', $info->youtube_url) }}" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label d-block">Status</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="active" {{ old('status', $info->status) == 'active' ? 'checked' : '' }}>
                                        <label class="form-check-label">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="inactive" {{ old('status', $info->status) == 'inactive' ? 'checked' : '' }}>
                                        <label class="form-check-label">Inactive</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
