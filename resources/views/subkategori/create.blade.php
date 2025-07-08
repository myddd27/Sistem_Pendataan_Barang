@extends('layouts.app')

@section('title', 'Tambah Subkategori')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('subkategori.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Subkategori</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                    @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mt-3">
                    <a href="{{ route('subkategori.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
