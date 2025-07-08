@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <style>
        .chart-container {
            height: 300px;
            display: flex;
            justify-content: center;
            /* Posisi horizontal tengah */
            align-items: center;
            /* Posisi vertikal tengah */
        }
    </style>
    
    <div class="container mt-4">
        {{-- Ringkasan --}}
        <div class="row g-4 mb-4">
            <div class="col-6 col-md-3">
                <div class="card shadow-sm border-0 text-white" style="background-color: #0d6efd;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="fs-6 fw-semibold">Total Barang</div>
                            <div class="fs-4 fw-bold">{{ $totalBarang }}</div>
                        </div>
                        <i class="bi bi-box-seam display-5 opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card shadow-sm border-0 text-white" style="background-color: #198754;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="fs-6 fw-semibold">Kategori</div>
                            <div class="fs-4 fw-bold">{{ $totalKategori }}</div>
                        </div>
                        <i class="bi bi-tags display-5 opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card shadow-sm border-0 text-white" style="background-color: #ffc107;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="fs-6 fw-semibold">Barang Masuk</div>
                            <div class="fs-4 fw-bold">{{ $barangMasuk }}</div>
                        </div>
                        <i class="bi bi-arrow-down-square display-5 opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card shadow-sm border-0 text-white" style="background-color: #dc3545;">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="fs-6 fw-semibold">Barang Keluar</div>
                            <div class="fs-4 fw-bold">{{ $barangKeluar }}</div>
                        </div>
                        <i class="bi bi-arrow-up-square display-5 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik --}}
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header fw-bold">
                        <i class="bi bi-bar-chart-line me-2"></i> Barang Masuk & Keluar
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartBarang"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header fw-bold">
                        <i class="bi bi-pie-chart me-2"></i> Distribusi Kategori
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartKategori"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Riwayat --}}
        <div class="card mt-5 shadow-sm">
            <div class="card-header fw-bold"><i class="bi bi-clock-history me-2"></i> Riwayat Barang Terbaru</div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Stok</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayatTerbaru as $riwayat)
                            <tr>
                                <td>{{ $riwayat->tanggal }}</td>
                                <td>{{ $riwayat->barang->nama }}</td>
                                <td>
                                    <span class="badge bg-{{ $riwayat->jenis == 'Masuk' ? 'success' : 'danger' }}">
                                        <i
                                            class="bi {{ $riwayat->jenis == 'Masuk' ? 'bi-box-arrow-in-down' : 'bi-box-arrow-up' }}"></i>
                                        {{ $riwayat->jenis }}
                                    </span>
                                </td>
                                <td>{{ $riwayat->jumlah }}</td>
                                <td>{{ $riwayat->barang->stok }}</td>
                                <td>{{ $riwayat->keterangan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Line Chart: Barang Masuk & Keluar
        const chartBarang = new Chart(document.getElementById('chartBarang'), {
            type: 'line',
            data: {
                labels: {!! json_encode($grafikTanggal) !!},
                datasets: [
                    {
                        label: 'Masuk',
                        data: {!! json_encode($grafikMasuk) !!},
                        borderColor: 'green',
                        backgroundColor: 'rgba(0,128,0,0.1)',
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Keluar',
                        data: {!! json_encode($grafikKeluar) !!},
                        borderColor: 'red',
                        backgroundColor: 'rgba(255,0,0,0.1)',
                        fill: true,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // Pie Chart: Kategori
        const chartKategori = new Chart(document.getElementById('chartKategori'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($labelKategori) !!},
                datasets: [{
                    data: {!! json_encode($jumlahKategori) !!},
                    backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1', '#0dcaf0'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>
@endpush