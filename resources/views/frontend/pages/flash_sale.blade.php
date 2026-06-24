@extends('frontend.dashboard')
@section('frontend_title', 'Excess Inventory')
@section('frontend_contents')

    {{-- Breadcrumb --}}
    <section class="page-header">
        <div class="page-header-bg" style="background-image: url({{ asset('frontend/assets/static_images/breadcrumb.jpg') }})"></div>
        <div class="container">
            <div class="page-header__inner">
                <h2>Excess Inventory</h2>
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><span>//</span></li>
                    <li>Excess Inventory</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="product">
        <div class="container">
            <div class="row">


                {{-- CONTENT --}}
                <div class="col-xl-12 col-lg-12">

                    {{-- Search --}}
                    <div class="shop-search product__sidebar-single product__price-ranger">
                        <div class="custom-sidebar-search">
                            <input type="text" id="exSearch" class="custom-sidebar-search__input" placeholder="Search particulars..." autocomplete="off">
                        </div>
                    </div>

                    <div class="product__items">

                        {{-- Showing --}}
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="product__showing-result d-flex justify-content-between align-items-center">
                                    <a href="#!" id="exClearAll" style="display:none;color:red;text-decoration:underline;">Clear All</a>
                                    <div id="exClearPlaceholder" style="visibility:hidden;">Clear All</div>
                                    <div class="product__showing-text-box">
                                        <p class="product__showing-text">
                                            Showing <span id="exVisibleCount">{{ $product_data->count() }}</span>
                                            of {{ $product_data->count() }} results
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- TABLE --}}
                        <div class="ex-table-wrapper">
                            <div class="table-responsive">
                                <table class="table ex-table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Particulars</th>
                                            <th width="220">Download</th>
                                            <th width="100">View</th>
                                        </tr>
                                    </thead>
                                    <tbody id="exTableBody">
                                        @forelse ($product_data as $item)
                                            <tr class="ex-row" data-name="{{ strtolower($item->particulars) }}" data-excel="{{ $item->excel_file ? asset($item->excel_file) : '' }}" data-pdf="{{ $item->pdf_file ? asset($item->pdf_file) : '' }}" data-title="{{ $item->particulars }}">

                                                <td>{{ $loop->iteration }}</td>

                                                <td>
                                                    <span class="ex-name">{{ $item->particulars }}</span>
                                                </td>

                                                <td>
                                                    <div class="d-flex gap-2 flex-wrap">
                                                        @if ($item->excel_file)
                                                            <a href="{{ asset($item->excel_file) }}" download class="ex-dl-btn ex-dl-excel">
                                                                <i class="bx bx-spreadsheet"></i> Excel
                                                            </a>
                                                        @endif
                                                        @if ($item->pdf_file)
                                                            <a href="{{ asset($item->pdf_file) }}" download class="ex-dl-btn ex-dl-pdf">
                                                                <i class="bx bxs-file-pdf"></i> PDF
                                                            </a>
                                                        @endif
                                                        @if (!$item->excel_file && !$item->pdf_file)
                                                            <span class="text-muted small">—</span>
                                                        @endif
                                                    </div>
                                                </td>

                                                <td>
                                                    @if ($item->excel_file || $item->pdf_file)
                                                        <button class="ex-view-btn" onclick="openExModal(
                                                            '{{ addslashes($item->particulars) }}',
                                                            '{{ $item->excel_file ? asset($item->excel_file) : '' }}',
                                                            '{{ $item->pdf_file ? asset($item->pdf_file) : '' }}'
                                                        )">
                                                            <i class="bx bx-show-alt"></i> View
                                                        </button>
                                                    @else
                                                        <span class="text-muted small">—</span>
                                                    @endif
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-5 text-muted">No products found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div id="exNoResult" class="text-center py-5 d-none">
                                <i class="bx bx-search-alt" style="font-size:50px;color:#cfd6e0;"></i>
                                <p class="text-muted mt-2">No products found</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- =========================
    MODAL
    ========================= --}}
    <div class="modal fade" id="exModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title mb-0" id="exModalTitle">-</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-0">

                    {{-- Tabs (only shown when both files exist) --}}
                    <div id="exFileTabs" class="px-3 pt-3" style="display:none;">
                        <ul class="nav nav-tabs border-bottom-0">
                            <li class="nav-item">
                                <button class="nav-link active" id="tabExcelBtn" onclick="switchExTab('excel')">
                                    <i class="bx bx-spreadsheet"></i> Excel
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="tabPdfBtn" onclick="switchExTab('pdf')">
                                    <i class="bx bxs-file-pdf"></i> PDF
                                </button>
                            </li>
                        </ul>
                    </div>

                    {{-- Excel View --}}
                    <div id="excelViewWrap" class="p-3" style="display:none;">
                        <div id="excelLoading" class="text-center py-5">
                            <div class="spinner-border text-primary"></div>
                            <p class="mt-2 text-muted small">Loading file...</p>
                        </div>
                        <div id="excelTableContent" class="table-responsive" style="display:none;"></div>
                    </div>

                    {{-- PDF View --}}
                    <div id="pdfViewWrap" style="display:none;">
                        <iframe id="pdfFrame" src="" style="width:100%;height:75vh;border:none;"></iframe>
                    </div>

                    {{-- No file --}}
                    <div id="noFileWrap" class="text-center py-5" style="display:none;">
                        <p class="text-muted">No file available to preview.</p>
                    </div>

                </div>

                <div class="modal-footer">
                    <div id="modalDownloadBtns"></div>
                    <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    {{-- =========================
    STYLES
    ========================= --}}
    <style>
        .ex-table-wrapper {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #edf0f5;
        }

        .ex-table thead {
            background: #0C447C;
        }

        .ex-table thead th {
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            padding: 16px 20px;
            border: none;
            white-space: nowrap;
        }

        .ex-table tbody td {
            padding: 14px 20px;
            vertical-align: middle;
            border-color: #eef1f5;
            font-size: 14px;
        }

        .ex-table tbody tr:hover {
            background: #f7fbff;
        }

        .ex-name {
            color: #0C447C;
            font-weight: 600;
        }

        .ex-dl-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: .2s;
        }

        .ex-dl-excel {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }

        .ex-dl-excel:hover {
            background: #2e7d32;
            color: #fff;
        }

        .ex-dl-pdf {
            background: #fdecea;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }

        .ex-dl-pdf:hover {
            background: #c62828;
            color: #fff;
        }

        .ex-view-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 12px;
            background: #0C447C;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: .2s;
        }

        .ex-view-btn:hover {
            background: #08345f;
        }

        #excelTableContent table {
            border-collapse: collapse;
            width: 100%;
            font-size: 13px;
        }

        #excelTableContent th {
            background: #f5f7fa;
            font-weight: 600;
            padding: 8px 12px;
            border: 1px solid #e0e4ea;
            text-align: left;
            white-space: nowrap;
        }

        #excelTableContent td {
            padding: 7px 12px;
            border: 1px solid #e9ecef;
            white-space: nowrap;
        }

        #excelTableContent tr:hover td {
            background: #f0f7ff;
        }

        /* Tab styling */
        #exFileTabs .nav-tabs {
            border-bottom: 2px solid #dee2e6;
        }

        #exFileTabs .nav-link {
            color: #6c757d;
            font-weight: 600;
            font-size: 13px;
            border: 1px solid transparent;
            border-bottom: none;
            padding: 8px 18px;
            cursor: pointer;
            background: none;
            border-radius: 6px 6px 0 0;
            transition: .2s;
        }

        #exFileTabs .nav-link:hover {
            color: #0C447C;
            background: #f0f7ff;
        }

        #exFileTabs .nav-link.active {
            color: #0C447C;
            background: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
            font-weight: 700;
        }
    </style>

    {{-- SheetJS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    {{-- =========================
    SCRIPTS
    ========================= --}}
    <script>
        /* ===== GLOBALS ===== */
        var _exExcelUrl = '';
        var _exPdfUrl = '';
        var _pdfLoaded = false;
        var _excelLoaded = false;

        /* ===== TAB SWITCH ===== */
        function switchExTab(tab) {
            if (tab === 'excel') {
                document.getElementById('tabExcelBtn').classList.add('active');
                document.getElementById('tabPdfBtn').classList.remove('active');
                document.getElementById('excelViewWrap').style.display = 'block';
                document.getElementById('pdfViewWrap').style.display = 'none';

                // Load excel if not yet loaded
                if (!_excelLoaded) {
                    loadExcel(_exExcelUrl);
                }

            } else {
                document.getElementById('tabPdfBtn').classList.add('active');
                document.getElementById('tabExcelBtn').classList.remove('active');
                document.getElementById('pdfViewWrap').style.display = 'block';
                document.getElementById('excelViewWrap').style.display = 'none';

                // PDF lazy load — set src only once
                if (!_pdfLoaded && _exPdfUrl) {
                    document.getElementById('pdfFrame').src = _exPdfUrl;
                    _pdfLoaded = true;
                }
            }
        }

        /* ===== OPEN MODAL ===== */
        function openExModal(title, excelUrl, pdfUrl) {
            _exExcelUrl = excelUrl;
            _exPdfUrl = pdfUrl;
            _pdfLoaded = false;
            _excelLoaded = false;

            document.getElementById('exModalTitle').textContent = title;

            // Reset all panels
            document.getElementById('excelViewWrap').style.display = 'none';
            document.getElementById('pdfViewWrap').style.display = 'none';
            document.getElementById('noFileWrap').style.display = 'none';
            document.getElementById('exFileTabs').style.display = 'none';
            document.getElementById('excelTableContent').style.display = 'none';
            document.getElementById('excelTableContent').innerHTML = '';
            document.getElementById('excelLoading').style.display = 'block';
            document.getElementById('pdfFrame').src = '';

            // Reset tabs to default active state
            document.getElementById('tabExcelBtn').classList.add('active');
            document.getElementById('tabPdfBtn').classList.remove('active');

            // Download buttons
            let btns = '';
            if (excelUrl) btns += `<a href="${excelUrl}" download class="ex-dl-btn ex-dl-excel me-2"><i class="bx bx-spreadsheet"></i> Download Excel</a>`;
            if (pdfUrl) btns += `<a href="${pdfUrl}" class="ex-dl-btn ex-dl-pdf me-2"><i class="bx bxs-file-pdf"></i> Download PDF</a>`;
            document.getElementById('modalDownloadBtns').innerHTML = btns;

            new bootstrap.Modal(document.getElementById('exModal')).show();

            const hasBoth = excelUrl && pdfUrl;

            if (hasBoth) {
                // Show tabs, default to Excel tab
                document.getElementById('exFileTabs').style.display = 'block';
                document.getElementById('excelViewWrap').style.display = 'block';
                loadExcel(excelUrl);

            } else if (excelUrl) {
                // Only Excel — no tabs
                document.getElementById('excelViewWrap').style.display = 'block';
                loadExcel(excelUrl);

            } else if (pdfUrl) {
                // Only PDF — no tabs
                document.getElementById('pdfViewWrap').style.display = 'block';
                document.getElementById('pdfFrame').src = pdfUrl;
                _pdfLoaded = true;

            } else {
                document.getElementById('noFileWrap').style.display = 'block';
            }
        }

        /* ===== LOAD EXCEL ===== */
        function loadExcel(url) {
            document.getElementById('excelLoading').style.display = 'block';
            document.getElementById('excelTableContent').style.display = 'none';
            document.getElementById('excelTableContent').innerHTML = '';

            fetch(url)
                .then(r => r.arrayBuffer())
                .then(buffer => {
                    const wb = XLSX.read(buffer, {
                        type: 'array'
                    });
                    const ws = wb.Sheets[wb.SheetNames[0]];
                    const html = XLSX.utils.sheet_to_html(ws, {
                        editable: false
                    });
                    document.getElementById('excelTableContent').innerHTML = html;
                    document.getElementById('excelTableContent').style.display = 'block';
                    document.getElementById('excelLoading').style.display = 'none';
                    _excelLoaded = true;
                })
                .catch(() => {
                    document.getElementById('excelLoading').innerHTML =
                        '<p class="text-danger text-center py-3">Failed to load Excel file.</p>';
                });
        }

        /* ===== CLIENT-SIDE SEARCH ===== */
        function applyExSearch() {
            const search = document.getElementById('exSearch').value.toLowerCase().trim();
            const rows = document.querySelectorAll('.ex-row');
            let visible = 0;

            rows.forEach(row => {
                const name = row.dataset.name || '';
                if (!search || name.includes(search)) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('exVisibleCount').textContent = visible;
            document.getElementById('exNoResult').classList.toggle('d-none', visible > 0);
            checkExFilters();
        }

        function checkExFilters() {
            const hasSearch = document.getElementById('exSearch').value.trim().length > 0;
            if (hasSearch) {
                document.getElementById('exClearAll').style.display = 'inline-block';
                document.getElementById('exClearPlaceholder').style.display = 'none';
            } else {
                document.getElementById('exClearAll').style.display = 'none';
                document.getElementById('exClearPlaceholder').style.display = 'block';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('exSearch').addEventListener('keyup', applyExSearch);
            document.getElementById('exClearAll').addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('exSearch').value = '';
                applyExSearch();
            });
        });
    </script>

@endsection
