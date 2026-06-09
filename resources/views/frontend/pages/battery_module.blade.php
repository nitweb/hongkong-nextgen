@extends('frontend.dashboard')
@section('frontend_title', 'Battery Management')
@section('frontend_contents')


    {{-- =========================
    BREADCRUMB
========================= --}}
    <section class="page-header battery-page-header mb-5">
        <div class="page-header-bg" style="background-image:url({{ asset('frontend/assets/static_images/breadcrumb.jpg') }})">
        </div>

        <div class="container">
            <div class="page-header__inner">
                <h2>Battery Management</h2>

                <ul class="thm-breadcrumb list-unstyled">
                    <li>
                        <a href="{{ route('index') }}">Home</a>
                    </li>

                    <li>
                        <span>//</span>
                    </li>

                    <li>Battery Management</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- =========================
    SLIDER (UNCHANGED)
========================= --}}
    @if ($ads->count())
        <section>
            <div class="container">
                <div id="batteryAdSlider" class="carousel slide battery-slider" data-bs-ride="carousel">

                    <div class="carousel-inner rounded-4 overflow-hidden">

                        @foreach ($ads as $i => $ad)
                            <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">

                                @if ($ad->link)
                                    <a href="{{ $ad->link }}" target="_blank">

                                        <img src="{{ asset($ad->image) }}" class="d-block w-100 battery-slider-img" alt="{{ $ad->title }}">

                                    </a>
                                @else
                                    <img src="{{ asset($ad->image) }}" class="d-block w-100 battery-slider-img" alt="{{ $ad->title }}">
                                @endif

                            </div>
                        @endforeach

                    </div>

                    @if ($ads->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#batteryAdSlider" data-bs-slide="prev">

                            <span class="carousel-control-prev-icon"></span>

                        </button>

                        <button class="carousel-control-next" type="button" data-bs-target="#batteryAdSlider" data-bs-slide="next">

                            <span class="carousel-control-next-icon"></span>

                        </button>
                    @endif

                </div>
            </div>
        </section>
    @endif

    {{-- =========================
    MAIN SECTION
========================= --}}
    <section class="product battery-module-section">

        <div class="container">

            <div class="row">

                {{-- =====================
                LEFT FILTER SIDEBAR
            ====================== --}}
                <div class="col-xl-3 col-lg-4">

                    <div class="product__sidebar">

                        {{-- CATEGORY --}}
                        <div class="shop-category product__sidebar-single">

                            <h3 class="product__sidebar-title">
                                Categories
                            </h3>

                            @php
                                $categories = $modules->pluck('category')->filter()->unique()->values();
                            @endphp

                            @foreach ($categories as $category)
                                <label class="filter-check">

                                    <input type="checkbox" class="js-filter-category" value="{{ strtolower($category) }}">

                                    {{ $category }}

                                    ({{ $modules->where('category', $category)->count() }})
                                </label>
                            @endforeach

                        </div>

                    </div>

                </div>

                {{-- =====================
                RIGHT CONTENT
            ====================== --}}
                <div class="col-xl-9 col-lg-8">

                    {{-- SEARCH BAR --}}
                    <div class="shop-search product__sidebar-single product__price-ranger mb-4">

                        <div class="custom-sidebar-search js-sidebar-search">

                            <input type="text" id="batterySearch" class="custom-sidebar-search__input" placeholder="Search battery item..." autocomplete="off">

                            <div class="search-icon">
                                <i class="bx bx-search"></i>
                            </div>

                        </div>

                    </div>

                    {{-- TOP RESULT --}}
                    <div class="row">

                        <div class="col-xl-12">

                            <div class="product__showing-result d-flex justify-content-between align-items-center">

                                <a href="#!" id="clear-all-filters" style="display:none;color:red;text-decoration:underline;">

                                    Clear All

                                </a>

                                <div id="clear-all-placeholder" style="visibility:hidden;flex:0 0 auto;color:red;text-decoration:underline;">

                                    Clear All

                                </div>

                                <div class="product__showing-text-box">

                                    <p class="product__showing-text">

                                        Showing
                                        <span id="visibleCount">
                                            {{ $modules->count() }}
                                        </span>

                                        of

                                        {{ $modules->count() }}

                                        items

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- =====================
                    TABLE LIST VIEW
                ====================== --}}
                    <div class="battery-table-wrapper">

                        <div class="table-responsive">

                            <table class="table battery-table align-middle">

                                <thead>

                                    <tr>
                                        <th width="80">SL</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th width="220">Category</th>
                                        <th width="140">Action</th>
                                    </tr>

                                </thead>

                                <tbody id="batteryTableBody">

                                    @forelse ($modules as $index => $module)
                                        <tr class="battery-row" data-title="{{ strtolower($module->title) }}" data-category="{{ strtolower($module->category) }}" data-desc="{{ strtolower($module->description) }}">

                                            <td>
                                                {{ $index + 1 }}
                                            </td>

                                            <td>
                                                @if ($module->thumbnail)
                                                    <img src="{{ asset($module->thumbnail) }}" style="width:70px;height:50px;object-fit:cover;border-radius:6px;">
                                                @else
                                                    <img src="{{ url('upload/no_image.jpg') }}" style="width:70px;height:50px;object-fit:cover;border-radius:6px;">
                                                @endif
                                            </td>

                                            <td>

                                                <a href="javascript:void(0)" class="battery-title-link" data-id="{{ $module->id }}" data-title="{{ $module->title }}" data-desc="{{ $module->description }}" data-category="{{ $module->category }}" data-file="{{ asset($module->file_path) }}" onclick="openBatteryModal(this)">

                                                    {{ $module->title }}

                                                </a>

                                            </td>

                                            <td>

                                                @if ($module->category)
                                                    <span class="battery-category-badge">
                                                        {{ $module->category }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">
                                                        --
                                                    </span>
                                                @endif

                                            </td>

                                            <td>

                                                <button class="btn btn-sm battery-view-btn" data-id="{{ $module->id }}" data-title="{{ $module->title }}" data-desc="{{ $module->description }}" data-category="{{ $module->category }}" data-file="{{ asset($module->file_path) }}" onclick="openBatteryModal(this)">

                                                    <i class="bx bx-show-alt me-1"></i>
                                                    View

                                                </button>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                No Battery Module Found
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                        {{-- NO RESULT --}}
                        <div id="noResult" class="text-center py-5 d-none">

                            <i class="bx bx-search-alt battery-no-result-icon"></i>

                            <p class="text-muted mt-3 mb-0">
                                No battery module found
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    {{-- =========================
    MODAL (UNCHANGED)
========================= --}}
    <div class="modal fade" id="batteryModal" tabindex="-1">

        <div class="modal-dialog modal-xl modal-dialog-scrollable">

            <div class="modal-content">

                <div class="modal-header">

                    <div>
                        <h5 class="modal-title mb-0" id="modalTitle">-</h5>

                        <small class="text-muted" id="modalCategory"></small>
                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body p-0">

                    {{-- DESCRIPTION --}}
                    <div id="modalDesc" class="px-4 pt-3 pb-2 text-muted small border-bottom">
                    </div>

                    {{-- EXCEL VIEWER --}}
                    <div id="excelTableWrap" class="p-3">

                        <div class="text-center py-5" id="excelLoading">

                            <div class="spinner-border text-primary"></div>

                            <p class="mt-2 text-muted small">
                                Loading file...
                            </p>

                        </div>

                        <div id="excelTable" class="table-responsive" style="display:none;">
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <a id="modalDownload" href="#" download class="btn btn-sm btn-outline-success">

                        <i class="bx bx-download me-1"></i>

                        Download

                    </a>

                    <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">

                        Close

                    </button>

                </div>

            </div>

        </div>

    </div>

    {{-- =========================
    STYLE
========================= --}}
    <style>
        /* =========================
            SLIDER
        ========================= */

        .battery-slider-img {
            height: 380px;
            object-fit: cover;
        }

        /* =========================
            SEARCH
        ========================= */

        .custom-sidebar-search {
            position: relative;
        }

        .custom-sidebar-search__input {
            width: 100%;
            height: 60px;
            border: none;
            outline: none;
            background: #f4f6f8;
            border-radius: 10px;
            padding: 0 60px 0 25px;
            font-size: 15px;
        }

        .search-icon {
            position: absolute;
            top: 50%;
            right: 22px;
            transform: translateY(-50%);
            font-size: 22px;
            color: #0C447C;
        }

        /* =========================
            TABLE
        ========================= */

        .battery-table-wrapper {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #edf0f5;
        }

        .battery-table {
            margin-bottom: 0;
        }

        .battery-table thead {
            background: #0C447C;
        }

        .battery-table thead th {
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            padding: 18px 20px;
            border: none;
            white-space: nowrap;
        }

        .battery-table tbody td {
            padding: 16px 20px;
            vertical-align: middle;
            border-color: #eef1f5;
            font-size: 14px;
        }

        .battery-table tbody tr {
            transition: all .2s ease;
        }

        .battery-table tbody tr:hover {
            background: #f7fbff;
        }

        .battery-title-link {
            color: #0C447C;
            font-weight: 600;
            text-decoration: none;
            transition: .2s;
        }

        .battery-title-link:hover {
            color: #ff6600;
        }

        .battery-category-badge {
            background: #E6F1FB;
            color: #0C447C;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
        }

        .battery-view-btn {
            background: #0C447C;
            color: #fff;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            transition: .2s;
        }

        .battery-view-btn:hover {
            background: #08345f;
            color: #fff;
        }

        .battery-no-result-icon {
            font-size: 55px;
            color: #cfd6e0;
        }

        /* =========================
            MODAL TABLE
        ========================= */

        #excelTable table {
            border-collapse: collapse;
            width: 100%;
            font-size: 13px;
        }

        #excelTable th {
            background: #f5f7fa;
            font-weight: 600;
            padding: 8px 12px;
            border: 1px solid #e0e4ea;
            text-align: left;
            white-space: nowrap;
        }

        #excelTable td {
            padding: 7px 12px;
            border: 1px solid #e9ecef;
            white-space: nowrap;
        }

        #excelTable tr:hover td {
            background: #f0f7ff;
        }

        .battery-module-section {
            padding: 70px 0 90px;
        }

        /* =========================
            MOBILE
        ========================= */

        @media(max-width:767px) {

            .battery-slider-img {
                height: 180px;
            }

            .battery-table thead th,
            .battery-table tbody td {
                white-space: nowrap;
            }

        }
    </style>

    {{-- SHEET JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    {{-- =========================
    SCRIPT
========================= --}}
    <script>
        /* =========================
            OPEN MODAL
        ========================= */

        function openBatteryModal(el) {
            const title = el.dataset.title;
            const desc = el.dataset.desc;
            const category = el.dataset.category;
            const fileUrl = el.dataset.file;

            document.getElementById('modalTitle').textContent = title;

            document.getElementById('modalCategory').textContent =
                category ? '📁 ' + category : '';

            document.getElementById('modalDesc').textContent =
                desc || '';

            document.getElementById('modalDesc').style.display =
                desc ? 'block' : 'none';

            document.getElementById('modalDownload').href =
                fileUrl;

            document.getElementById('excelTable').style.display =
                'none';

            document.getElementById('excelLoading').style.display =
                'block';

            new bootstrap.Modal(
                document.getElementById('batteryModal')
            ).show();

            fetch(fileUrl)

                .then(r => r.arrayBuffer())

                .then(buffer => {

                    const wb = XLSX.read(buffer, {
                        type: 'array'
                    });

                    const ws = wb.Sheets[wb.SheetNames[0]];

                    const html = XLSX.utils.sheet_to_html(ws, {
                        editable: false
                    });

                    document.getElementById('excelTable').innerHTML =
                        html;

                    document.getElementById('excelTable').style.display =
                        'block';

                    document.getElementById('excelLoading').style.display =
                        'none';

                })

                .catch(() => {

                    document.getElementById('excelLoading').innerHTML =
                        '<p class="text-danger">Failed to load file.</p>';

                });
        }

        /* =========================
            FILTER + SEARCH
        ========================= */

        function applyBatteryFilter() {
            const search =
                document.getElementById('batterySearch')
                .value
                .toLowerCase()
                .trim();

            const checkedCategories = [...document.querySelectorAll('.js-filter-category:checked')]
                .map(el => el.value);

            const rows =
                document.querySelectorAll('.battery-row');

            let visible = 0;

            rows.forEach(row => {

                const title =
                    row.dataset.title || '';

                const category =
                    row.dataset.category || '';

                const desc =
                    row.dataset.desc || '';

                const matchSearch =
                    title.includes(search) ||
                    category.includes(search) ||
                    desc.includes(search);

                let matchCategory = true;

                if (checkedCategories.length > 0) {
                    matchCategory =
                        checkedCategories.includes(category);
                }

                if (matchSearch && matchCategory) {

                    row.style.display = '';
                    visible++;

                } else {

                    row.style.display = 'none';

                }

            });

            document.getElementById('visibleCount').textContent =
                visible;

            document.getElementById('noResult')
                .classList
                .toggle('d-none', visible > 0);

            checkBatteryFilters();
        }

        /* =========================
            CLEAR ALL
        ========================= */

        function checkBatteryFilters() {
            const hasCategory =
                document.querySelectorAll('.js-filter-category:checked').length > 0;

            const hasSearch =
                document.getElementById('batterySearch')
                .value
                .trim()
                .length > 0;

            if (hasCategory || hasSearch) {

                document.getElementById('clear-all-filters')
                    .style.display = 'inline-block';

                document.getElementById('clear-all-placeholder')
                    .style.display = 'none';

            } else {

                document.getElementById('clear-all-filters')
                    .style.display = 'none';

                document.getElementById('clear-all-placeholder')
                    .style.display = 'block';

            }
        }

        /* =========================
            EVENTS
        ========================= */

        document.addEventListener('DOMContentLoaded', function() {

            // SEARCH
            document.getElementById('batterySearch')
                .addEventListener('keyup', applyBatteryFilter);

            // CATEGORY
            document.querySelectorAll('.js-filter-category')
                .forEach(el => {

                    el.addEventListener('change', applyBatteryFilter);

                });

            // CLEAR ALL
            document.getElementById('clear-all-filters')
                .addEventListener('click', function(e) {

                    e.preventDefault();

                    document.getElementById('batterySearch').value = '';

                    document.querySelectorAll('.js-filter-category')
                        .forEach(el => el.checked = false);

                    applyBatteryFilter();

                });

        });
    </script>

@endsection
