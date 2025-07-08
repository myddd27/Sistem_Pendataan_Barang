<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin') - Sistem Barang Logistik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">


    <style>
        .nav-link.active {
            background-color: #6c757d !important;
            font-weight: bold;
            border-radius: 0.375rem;
        }

        /* Sidebar tetap untuk desktop */
        @media (min-width: 992px) {
            #sidebar {
                width: 250px;
                position: fixed;
                height: 100vh;
                z-index: 1030;
                transform: none !important;
                visibility: visible !important;
                background-color: #212529;
            }

            main {
                margin-left: 250px;
            }

            .offcanvas-backdrop {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div>

        {{-- Sidebar --}}
        <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="sidebar">
            <div class="offcanvas-header border-bottom border-secondary">
                <h5 class="offcanvas-title">Sistem Barang Logistik</h5>
                <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-3">
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="{{ route('dashboard') }}"
                            class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->routeIs('kategori.*') || request()->routeIs('subkategori.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" href="#menuKategori" role="button"
                            aria-expanded="{{ request()->routeIs('kategori.*') || request()->routeIs('subkategori.*') ? 'true' : 'false' }}"
                            aria-controls="menuKategori">
                            <span><i class="bi bi-tags me-2"></i> Data Klasifikasi</span>
                            <i class="bi bi-caret-down-fill small"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('kategori.*') || request()->routeIs('subkategori.*') ? 'show' : '' }}"
                            id="menuKategori">
                            <ul class="nav flex-column ms-3 mt-1">
                                <li class="nav-item">
                                    <a href="{{ route('kategori.index') }}"
                                        class="nav-link text-white {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                                        <i class="bi bi-dot me-2"></i> Klasifikasi
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('subkategori.index') }}"
                                        class="nav-link text-white {{ request()->routeIs('subkategori.*') ? 'active' : '' }}">
                                        <i class="bi bi-dot me-2"></i> Subklasifikasi
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('barang.index') }}"
                            class="nav-link text-white {{ request()->routeIs('barang.*') ? 'active' : '' }}">
                            <i class="bi bi-box me-2"></i> Data Barang
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('transaksibarang.index') }}"
                            class="nav-link text-white {{ request()->routeIs('transaksibarang.*') ? 'active' : '' }}">
                            <i class="bi bi-arrow-left-right me-2"></i> Transaksi Barang
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('laporan.index') }}"
                            class="nav-link text-white {{ request()->routeIs('laporan.index') ? 'active' : '' }}">
                            <i class="bi bi-journal-text me-2"></i> Laporan
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-light w-100">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Top Navbar (Mobile Only) --}}
        <header
            class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom d-lg-none bg-white shadow-sm">
            <button class="btn btn-outline-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                <i class="bi bi-list"></i>
            </button>
            <span class="fw-bold">Sistem Barang Logistik</span>
        </header>

        {{-- Main Content --}}
        <main class="p-4">
            <h4 class="mb-4">@yield('title')</h4>
            @yield('content')
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (dibutuhkan oleh DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- DataTables Buttons Extension -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
    @stack('scripts')
</body>
</html>