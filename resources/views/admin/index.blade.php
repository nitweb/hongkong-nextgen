@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Breadcrumb --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dabo Bunny</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Frontend Visit Card --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm gradient-banner text-white p-4 d-flex flex-md-row flex-column align-items-center justify-content-between">
                        <div class="mb-3 mb-md-0">
                            <h4 class="fw-bold mb-1 text-white">View Your Website</h4>
                            <p class="mb-0 opacity-75">Click below to open the live frontend of your site.</p>
                        </div>
                        <a href="{{ route('index') }}" target="_blank" class="btn btn-light text-primary fw-semibold px-4 py-2 rounded-pill shadow-sm hover-scale">
                            🌐 Visit Frontend
                        </a>
                    </div>
                </div>
            </div>

            {{-- Dashboard Cards --}}
            <div class="row g-4">

                {{-- Total Products --}}
                <div class="col-xl-6 col-md-6">
                    <a href="{{ route('backend.products.list') }}" class="text-decoration-none text-dark">
                        <div class="card stats-card shadow-sm border-0">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Total Products</h6>
                                    <h2 class="fw-bold mb-0">{{ $productCount ?? 0 }}</h2>
                                </div>
                                <div class="icon-box bg-gradient-primary">
                                    <i class="bx bx-cube text-white fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Number of Orders --}}
                <div class="col-xl-6 col-md-6">
                    <a href="{{ route('backend.bulk_order.list') }}" class="text-decoration-none text-dark">
                        <div class="card stats-card shadow-sm border-0">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Number of Orders</h6>
                                    <h2 class="fw-bold mb-0">{{ $orderCount ?? 0 }}</h2>
                                </div>
                                <div class="icon-box bg-gradient-success">
                                    <i class="bx bx-cart text-white fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Total Blogs --}}
                <div class="col-xl-6 col-md-6">
                    <a href="{{ route('backend.blog.list') }}" class="text-decoration-none text-dark">
                        <div class="card stats-card shadow-sm border-0">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Total Blogs</h6>
                                    <h2 class="fw-bold mb-0">{{ $blogCount ?? 0 }}</h2>
                                </div>
                                <div class="icon-box bg-gradient-warning">
                                    <i class="bx bx-news text-white fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Contacts --}}
                <div class="col-xl-6 col-md-6">
                    <a href="{{ route('backend.contact_form.list') }}" class="text-decoration-none text-dark">
                        <div class="card stats-card shadow-sm border-0">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Contacts</h6>
                                    <h2 class="fw-bold mb-0">{{ $contactCount ?? 0 }}</h2>
                                </div>
                                <div class="icon-box bg-gradient-danger">
                                    <i class="bx bx-envelope text-white fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- Custom Styles --}}
    <style>
        .stats-card {
            transition: all 0.25s ease-in-out;
            border-radius: 12px;
        }

        a .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .icon-box {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-gradient-primary {
            background: linear-gradient(45deg, #007bff, #00b4ff);
        }

        .bg-gradient-success {
            background: linear-gradient(45deg, #28a745, #85e085);
        }

        .bg-gradient-warning {
            background: linear-gradient(45deg, #ffc107, #ffb347);
        }

        .bg-gradient-danger {
            background: linear-gradient(45deg, #dc3545, #ff6b6b);
        }

        a {
            color: inherit;
        }

        a:hover {
            text-decoration: none;
        }

        a .stats-card {
            cursor: pointer;
        }

        .gradient-banner {
            background: linear-gradient(90deg, #e74399, #6cb446);
            border-radius: 15px;
        }

        .hover-scale {
            transition: all 0.25s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(255, 255, 255, 0.3);
        }
    </style>
@endsection
