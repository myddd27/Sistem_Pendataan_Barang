@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="kategori" class="form-label">Nama Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control"
                        value="{{ old('kategori', $kategori->kategori ?? '') }}" required>
                    @error('kategori')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                </div>
                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
@endsection