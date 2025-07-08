@extends('layouts.app')

@section('title', 'Tambah Riwayat Barang')

@section('content')
<div class="container">
    <!-- <h3 class="mb-4">Tambah Riwayat Barang</h3> -->

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups!</strong> Ada kesalahan:<br>
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('transaksibarang.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="barang_id" class="form-label">Barang</label>
            <select name="barang_id" id="barang_id" class="form-select" required>
                <option value="">-- Pilih Barang --</option>
                @foreach ($barang as $b)
                    <option value="{{ $b->id }}" {{ old('barang_id') == $b->id ? 'selected' : '' }}>{{ $b->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="jenis" class="form-label">Jenis</label>
            <select name="jenis" id="jenis" class="form-select" required>
                <option value="">-- Pilih Jenis --</option>
                <option value="Masuk" {{ old('jenis') == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                <option value="Keluar" {{ old('jenis') == 'Keluar' ? 'selected' : '' }}>Keluar</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" min="1" value="{{ old('jumlah') }}" required>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') ?? date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan (opsional)</label>
            <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('transaksibarang.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
