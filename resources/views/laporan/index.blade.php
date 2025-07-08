@extends('layouts.app')

@section('title', 'Laporan Transaksi Barang')

@section('content')
    <div class="table-responsive">
        <table id="laporanTable" class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Kategori</th>
                    <th>Subkategori</th>
                    <th>Stok</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporan as $item)
                    <tr>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->barang->nama }}</td>
                        <td>
                            <span class="badge bg-{{ $item->jenis == 'Masuk' ? 'success' : 'danger' }}">
                                <i class="bi {{ $item->jenis == 'Masuk' ? 'bi-box-arrow-in-down' : 'bi-box-arrow-up' }}"></i>
                                {{ $item->jenis }}
                            </span>
                        </td>
                        <td>{{ $item->jumlah }}</td>
                        <td>{{ $item->barang->kategori->kategori }}</td>
                        <td>{{ $item->barang->subkategori->nama }}</td>
                        <td>{{ $item->barang->stok }}</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
@endpush

@push('scripts')
    <!-- jQuery & DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
        $(document).ready(function () {
            $('#laporanTable').DataTable({
                order: [[1, 'desc']],
                columnDefs: [
                    {
                        targets: 0,
                        type: 'date'
                    }
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
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'print',
                        text: '<i class="bi bi-printer"></i> Cetak',
                        className: 'btn btn-secondary'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                        className: 'btn btn-danger'
                    }
                ]
            });
        });
    </script>
@endpush