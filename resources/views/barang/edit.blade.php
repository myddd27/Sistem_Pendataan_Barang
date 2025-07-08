@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('barang.update', $barang->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $barang->nama) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kode Barang</label>
                    <input type="text" name="kode" class="form-control" value="{{ old('kode', $barang->kode) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ $barang->kategori_id == $k->id ? 'selected' : '' }}>
                                {{ $k->kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Subkategori</label>
                    <select name="subkategori_id" id="subkategori_id" class="form-select" required>
                        <option value="">-- Pilih Subkategori --</option>
                        @foreach($subkategori as $s)
                            <option value="{{ $s->id }}" {{ $barang->subkategori_id == $s->id ? 'selected' : '' }}>
                                {{ $s->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" value="{{ old('stok', $barang->stok) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control" value="{{ old('satuan', $barang->satuan) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Harga</label>
                    <input type="text" name="harga" id="harga" class="form-control"
                        value="{{ old('harga', 'Rp ' . number_format($barang->harga, 0, ',', '.')) }}" required>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hargaInput = document.getElementById('harga');
        hargaInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            value = new Intl.NumberFormat('id-ID').format(value);
            e.target.value = 'Rp ' + value;
        });
    });
</script>
@endsection
