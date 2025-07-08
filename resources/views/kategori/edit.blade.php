@extends('layouts.app')

@section('title', 'Edit Klasifikasi')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="kategori" class="form-label">Nama Klasifikasi</label>
                    <input type="text" name="kategori" id="kategori" class="form-control"
                        value="{{ old('kategori', $kategori->kategori ?? '') }}" required>
                    @error('kategori')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                </div>
                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection