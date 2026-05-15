@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Breadcrumb --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Site Settings Edit</h4>
                        <div class="page-title-right">
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
                        <div class="card-body p-4">

                            @include('widgets.errors')

                            <form class="row g-3" action="{{ route('backend.site_settings.update') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                {{-- ===== LOGOS ===== --}}
                                <div class="col-md-6">
                                    <label for="site_header_logo" class="form-label">Site Header Logo</label>
                                    <input type="file" class="form-control" name="site_header_logo" id="site_header_logo">
                                    <img id="showHeaderLogo" src="{{ !empty($site_settings_info->site_header_logo) ? url($site_settings_info->site_header_logo) : url('upload/no_image.jpg') }}" alt="Header Logo" class="p-1 bg-primary mt-3" style="width:40%;object-fit:cover;border-radius:8px;">
                                </div>

                                <div class="col-md-6">
                                    <label for="site_footer_logo" class="form-label">Site Footer Logo</label>
                                    <input type="file" class="form-control" name="site_footer_logo" id="site_footer_logo">
                                    <img id="showFooterLogo" src="{{ !empty($site_settings_info->site_footer_logo) ? url($site_settings_info->site_footer_logo) : url('upload/no_image.jpg') }}" alt="Footer Logo" class="p-1 bg-primary mt-3" style="width:40%;object-fit:cover;border-radius:8px;">
                                </div>

                                {{-- ===== GENERAL ===== --}}
                                <div class="col-md-12">
                                    <label for="site_address" class="form-label">Site Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="site_address" name="site_address" value="{{ old('site_address', $site_settings_info->site_address) }}" required>
                                </div>

                                <div class="col-md-12">
                                    <label for="site_description" class="form-label">Site Description</label>
                                    <textarea class="form-control" id="site_description" name="site_description" rows="4">{{ old('site_description', $site_settings_info->site_description) }}</textarea>
                                </div>

                                <div class="col-md-6">
                                    <label for="site_copyright" class="form-label">Site Copyright <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="site_copyright" name="site_copyright" value="{{ old('site_copyright', $site_settings_info->site_copyright) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="site_google_map" class="form-label">Site Google Map</label>
                                    <input type="text" class="form-control" id="site_google_map" name="site_google_map" value="{{ old('site_google_map', $site_settings_info->site_google_map) }}">
                                </div>

                                {{-- ===== PERSON 1 ===== --}}
                                <div class="col-12">
                                    <hr>
                                    <h5 class="mb-3">Person 1 <small class="text-muted fs-6">(Optional)</small></h5>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="person1_name" value="{{ old('person1_name', $site_settings_info->person1_name) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="person1_email" value="{{ old('person1_email', $site_settings_info->person1_email) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="person1_phone" value="{{ old('person1_phone', $site_settings_info->person1_phone) }}">
                                </div>

                                {{-- ===== PERSON 2 ===== --}}
                                <div class="col-12">
                                    <hr>
                                    <h5 class="mb-3">Person 2 <small class="text-muted fs-6">(Optional)</small></h5>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="person2_name" value="{{ old('person2_name', $site_settings_info->person2_name) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="person2_email" value="{{ old('person2_email', $site_settings_info->person2_email) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="person2_phone" value="{{ old('person2_phone', $site_settings_info->person2_phone) }}">
                                </div>

                                {{-- ===== PERSON 3 ===== --}}
                                <div class="col-12">
                                    <hr>
                                    <h5 class="mb-3">Person 3 <small class="text-muted fs-6">(Optional)</small></h5>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="person3_name" value="{{ old('person3_name', $site_settings_info->person3_name) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="person3_email" value="{{ old('person3_email', $site_settings_info->person3_email) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="person3_phone" value="{{ old('person3_phone', $site_settings_info->person3_phone) }}">
                                </div>

                                <div class="col-12 mt-3">
                                    <hr>
                                    <button type="submit" class="btn btn-sm btn-primary px-4">
                                        <i class="bx bx-save me-1"></i> Update
                                    </button>
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
            $('#site_header_logo').change(function(e) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#showHeaderLogo').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            });
            $('#site_footer_logo').change(function(e) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#showFooterLogo').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>

    @include('admin.layout.custom_scripts')
@endsection
