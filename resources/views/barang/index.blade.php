@extends('layouts.app')

@section('title', 'Data Barang')

@section('content')
    <a href="{{ route('barang.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Tambah Barang
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table id="barangTable" class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kode</th>
                    <th>Klasifikasi</th>
                    <th>Subklasifikasi</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                    <th class="no-sort">
                        Harga
                        <button id="toggleHarga" class="btn btn-sm btn-outline-light ms-2" title="Tampilkan/Sembunyikan Harga">
                            <i class="bi bi-eye-slash" id="iconToggleHarga"></i>
                        </button>
                    </th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barang as $index => $b)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $b->nama }}</td>
                        <td>{{ $b->kode }}</td>
                        <td>{{ $b->kategori->kategori ?? '-' }}</td>
                        <td>{{ $b->subkategori->nama ?? '-' }}</td>
                        <td>{{ $b->stok }}</td>
                        <td>{{ $b->satuan }}</td>
                        <td class="harga-cell">Rp {{ number_format($b->harga, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <a href="{{ route('barang.edit', $b->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('barang.destroy', $b->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
    <!-- jQuery & DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            const table = $('#barangTable').DataTable({
                columnDefs: [
                    { targets: 'no-sort', orderable: false }
                ],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data tersedia",
                    zeroRecords: "Data tidak ditemukan",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "→",
                        previous: "←"
                    },
                },
                responsive: true
            });

            let hargaVisible = true;
            $('#toggleHarga').on('click', function (e) {
                e.preventDefault();

                $('.harga-cell').each(function () {
                    const cell = $(this);
                    if (hargaVisible) {
                        const angka = cell.text();
                        cell.data('harga', angka);
                        cell.text('****');
                    } else {
                        cell.text(cell.data('harga'));
                    }
                });

                $('#iconToggleHarga').toggleClass('bi-eye-slash bi-eye');
                hargaVisible = !hargaVisible;
            });
        });
    </script>
@endpush
