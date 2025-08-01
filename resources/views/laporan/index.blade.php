@extends('layouts.app')

@section('title', 'Laporan Transaksi Barang')

@section('content')
    <form method="GET" action="{{ route('laporan.index') }}" class="row gx-3 gy-2 align-items-end mb-4">
        <div class="row gx-2 gy-2 align-items-end mb-4">
            <div class="col-md-3">
                <label for="tipe_waktu" class="form-label mb-1">Filter Waktu</label>
                <select name="tipe_waktu" id="tipe_waktu" class="form-select">
                    <option value="">-- Pilih --</option>
                    <option value="harian" {{ request('tipe_waktu') == 'harian' ? 'selected' : '' }}>Per Hari</option>
                    <option value="mingguan" {{ request('tipe_waktu') == 'mingguan' ? 'selected' : '' }}>Per Minggu</option>
                    <option value="bulanan" {{ request('tipe_waktu') == 'bulanan' ? 'selected' : '' }}>Per Bulan</option>
                </select>
            </div>

            {{-- Input tanggal dinamis di sini --}}
            <div class="col-md-3 d-none" id="filter-harian">
                <label class="form-label mb-1">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
            </div>

            <div class="col-md-3 d-none" id="filter-mingguan">
                <label class="form-label mb-1">Minggu</label>
                <input type="week" name="minggu" class="form-control" value="{{ request('minggu') }}">
            </div>

            <div class="col-md-3 d-none" id="filter-bulanan">
                <label class="form-label mb-1">Bulan</label>
                <input type="month" name="bulan" class="form-control" value="{{ request('bulan') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label mb-1 text-white">.</label>
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-funnel-fill me-1"></i> Tampilkan
                </button>
            </div>

            <div class="col-md-2">
                <label class="form-label mb-1 text-white">.</label>
                <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                </a>
            </div>
        </div>
    </form>

    <div class="mb-3">
        <button class="btn btn-secondary btn-sm print-btn"><i class="bi bi-printer"></i> Cetak</button>
        <button class="btn btn-success btn-sm excel-btn"><i class="bi bi-file-earmark-excel"></i> Excel</button>
        <button class="btn btn-danger btn-sm pdf-btn"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
    </div>

    <div class="table-responsive">
        <table id="laporanTable" class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Tanggal</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Kategori</th>
                    <th>Subkategori</th>
                    <th>Stok</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporan as $item)
                    @php
                        $harga = $item->barang->harga;
                        $jumlah = $item->jumlah;
                        $subtotal = $harga * $jumlah;
                    @endphp
                    <tr>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->barang->kode }}</td>
                        <td>{{ $item->barang->nama }}</td>
                        <td>
                            <span class="badge bg-{{ $item->jenis == 'Masuk' ? 'success' : 'danger' }}">
                                <i class="bi {{ $item->jenis == 'Masuk' ? 'bi-box-arrow-in-down' : 'bi-box-arrow-up' }}"></i>
                                {{ $item->jenis }}
                            </span>
                        </td>
                        <td>{{ $jumlah }}</td>
                        <td>Rp {{ number_format($harga, 0, ',', '.') }}</td>
                        <td data-subtotal="{{ $subtotal }}">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td>{{ $item->barang->kategori->kategori }}</td>
                        <td>{{ $item->barang->subkategori?->nama }}</td>
                        <td>{{ $item->barang->stok }}</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
@endsection

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

        <style>
            @media print {
                #laporan-subtotal {
                    display: block !important;
                    font-weight: bold;
                    text-align: right;
                    margin-top: 10px;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

        <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

        <script>
            $(document).ready(function () {
                const table = $('#laporanTable').DataTable({
                    order: [[1, 'desc']],
                    responsive: true,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'print',
                            footer: false,
                            title: 'Laporan Transaksi Barang',
                            className: 'd-none',
                            customize: function (win) {
                                let subtotal = hitungSubtotal();
                                $(win.document.body).append('<h5 style="text-align:right;margin-top:20px;">Subtotal: Rp ' + subtotal.toLocaleString('id-ID') + '</h5>');
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            footer: false,
                            title: 'Laporan_Transaksi_Barang',
                            className: 'd-none',
                            customize: function (xlsx) {
                                const sheet = xlsx.xl.worksheets['sheet1.xml'];

                                // Hitung subtotal dari data-subtotal
                                let subtotal = 0;
                                $('#laporanTable tbody tr').each(function () {
                                    const val = parseInt($(this).find('td:eq(6)').data('subtotal')) || 0;
                                    subtotal += val;
                                });

                                // Cari baris terakhir untuk menentukan index baris subtotal
                                const rows = $('row', sheet);
                                const lastRowIndex = parseInt(rows.last().attr('r')) + 1;

                                // Tambahkan baris subtotal ke cell F dan G (kolom Harga dan Total)
                                const subtotalXml = `
                                                    <row r="${lastRowIndex}">
                                                        <c t="inlineStr" r="F${lastRowIndex}"><is><t>Subtotal</t></is></c>
                                                        <c t="inlineStr" r="G${lastRowIndex}"><is><t>Rp ${subtotal.toLocaleString('id-ID')}</t></is></c>
                                                    </row>`;

                                sheet.childNodes[0].innerHTML = sheet.childNodes[0].innerHTML.replace('</sheetData>', subtotalXml + '</sheetData>');
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            orientation: 'landscape',
                            pageSize: 'A4',
                            footer: false,
                            title: 'Laporan Transaksi Barang',
                            className: 'd-none',
                            customize: function (doc) {
                                let subtotal = hitungSubtotal();
                                doc.content.push({
                                    text: 'Subtotal: Rp ' + subtotal.toLocaleString('id-ID'),
                                    alignment: 'right',
                                    margin: [0, 10, 0, 0],
                                    bold: true
                                });
                            }
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
                    // initComplete: updateSubtotalDisplay,
                    // drawCallback: updateSubtotalDisplay
                });

                function hitungSubtotal() {
                    let subtotal = 0;
                    $('#laporanTable tbody tr').each(function () {
                        const val = parseInt($(this).find('td:eq(6)').data('subtotal')) || 0;
                        subtotal += val;
                    });
                    return subtotal;
                }

                // function updateSubtotalDisplay() {
                //     let subtotal = hitungSubtotal();
                //     $('#laporan-subtotal').text('Subtotal: Rp ' + subtotal.toLocaleString('id-ID'));
                // }

                $('.print-btn').on('click', function () {
                    table.button('.buttons-print').trigger();
                });
                $('.excel-btn').on('click', function () {
                    table.button('.buttons-excel').trigger();
                });
                $('.pdf-btn').on('click', function () {
                    table.button('.buttons-pdf').trigger();
                });

                function toggleInputs() {
                    const tipe = document.getElementById('tipe_waktu').value;
                    document.getElementById('filter-harian').classList.add('d-none');
                    document.getElementById('filter-mingguan').classList.add('d-none');
                    document.getElementById('filter-bulanan').classList.add('d-none');

                    if (tipe === 'harian') {
                        document.getElementById('filter-harian').classList.remove('d-none');
                    } else if (tipe === 'mingguan') {
                        document.getElementById('filter-mingguan').classList.remove('d-none');
                    } else if (tipe === 'bulanan') {
                        document.getElementById('filter-bulanan').classList.remove('d-none');
                    }
                }

                // Jalanin saat halaman dibuka
                window.addEventListener('DOMContentLoaded', toggleInputs);
                // Tambahkan event listener juga untuk perubahan pilihan
                document.getElementById('tipe_waktu').addEventListener('change', toggleInputs);
            });
        </script>
    @endpush