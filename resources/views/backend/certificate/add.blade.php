@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="container-fluid">

            {{-- Breadcrumb  --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ $title }} Add</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.certificate.list') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-list-ul me-1"></i> {{ $title }} List
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

                            <form class="row g-3" action="{{ route('backend.certificate.store') }}" method="post" enctype="multipart/form-data" novalidate>

                                @csrf

                                <div class="col-md-8">
                                    <label for="example-text-input" class="form-label">Certificate Image</label>
                                    <input type="file" class="form-control" name="certificate_image" id="image" required>
                                    <img id="showImage" src="{{ asset('upload/no_image.jpg') }}" alt="Certificate Image" class="p-1 bg-primary mt-3" style="width: 110px; height: 110px; object-fit: cover; border-radius: 8px;">
                                </div>

                                <div class="col-md-8">
                                    <label for="certificate_title" class="form-label">Certificate Title</label>
                                    <input type="text" class="form-control" id="certificate_title" name="certificate_title" value="{{ old('certificate_title') }}" required>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-primary">Create {{ $title }}</button>
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

    {{-- Toastr Script --}}
@endsection
