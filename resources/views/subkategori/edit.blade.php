@extends('layouts.app')

@section('title', 'Edit Subkategori')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('subkategori.update', $subkategori->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama Subkategori</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $subkategori->nama) }}" required>
                    @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id', $subkategori->kategori_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mt-4">
                    <a href="{{ route('subkategori.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
