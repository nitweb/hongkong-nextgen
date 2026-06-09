@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Breadcrumb --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Battery Ad Edit</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.battery.ad.list') }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-list-ul font-size-16 align-middle me-2"></i> Battery Ad List
                            </a>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark waves-effect waves-light">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-4">

                            @include('widgets.errors')

                            <form class="row g-3" action="{{ route('backend.battery.ad.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="ad_id" value="{{ $ad->id }}">

                                <div class="col-md-12">
                                    <label class="form-label">Ad Image [1200px × 400px]</label>
                                    <input type="file" class="form-control" name="image" id="adImage">
                                    <img id="showImage" src="{{ !empty($ad->image) ? url($ad->image) : url('upload/no_image.jpg') }}" alt="Ad Preview" class="p-1 bg-primary mt-3" style="width: 200px; height: 100px; object-fit: cover; border-radius: 8px;">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Title <span class="text-muted">(optional)</span></label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title', $ad->title) }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Link <span class="text-muted">(optional)</span></label>
                                    <input type="url" class="form-control" name="link" value="{{ old('link', $ad->link) }}" placeholder="https://...">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Sort Order</label>
                                    <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $ad->sort_order) }}" min="0">
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Update Battery Ad</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#adImage').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>
    @include('admin.layout.custom_scripts')
@endsection
