@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="container-fluid">

            {{-- Breadcrumb  --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Blog Add</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.blog.list') }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-list-ul font-size-16 align-middle me-2"></i> Blog List
                            </a>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark waves-effect waves-light">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Custom Form --}}
            <div class="row">

                <div class="col-12">

                    <div class="card">

                        <div class="card-body p-4">

                            @include('widgets.errors')

                            <form class="row g-3" action="{{ route('backend.blog.store') }}" method="post" enctype="multipart/form-data" novalidate>

                                @csrf

                                <div class="col-md-8">
                                    <label for="example-text-input" class="form-label">Image [1200px by 628px]</label>
                                    <input type="file" class="form-control" name="blog_image" id="image" required>
                                    <img id="showImage" src="{{ asset('upload/no_image.jpg') }}" alt="Blog Image" class="p-1 bg-primary mt-3" style="width: 110px; height: 110px; object-fit: cover; border-radius: 8px;">
                                </div>

                                <div class="col-md-8">
                                    <label for="blog_title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="blog_title" name="blog_title" value="{{ old('blog_title') }}" required>
                                </div>

                                <div class="col-md-8">
                                    <label for="blog_slug" class="form-label">Blog Slug <span class="text-danger">[except unique slug only]</span></label>
                                    <input type="text" class="form-control" id="blog_slug" name="blog_slug" value="{{ old('blog_slug') }}" required>
                                </div>

                                <div class="col-md-8">
                                    <label for="blog_short_description" class="form-label">Short Description</label>
                                    <textarea class="form-control" id="blog_short_description" name="blog_short_description" rows="4" required>{{ old('blog_short_description') }}</textarea>
                                </div>

                                <div class="col-8">
                                    <label class="form-label">Long Description</label>
                                    <textarea class="form-control" name="blog_long_description" id="summernote" required>{{ old('blog_long_description') }}</textarea>
                                </div>

                                <div class="col-md-8">
                                    <label for="blog_category_id" class="form-label">Blog Category</label>
                                    <select class="form-select" id="blog_category_id" name="blog_category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach ($blog_categories as $category)
                                            <option value="{{ $category->id }}" {{ old('blog_category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->blog_category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-8">
                                    <label for="blog_tags" class="form-label">Tags <span class="text-muted">(comma separated)</span></label>
                                    <input type="text" class="form-control" id="blog_tags" name="blog_tags" value="{{ old('blog_tags') }}">
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-primary">Create</button>
                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            })
        })
    </script>

    @include('admin.layout.custom_scripts')
@endsection
