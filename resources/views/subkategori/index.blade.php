@extends('layouts.app')

@section('title', 'Data Subklasifikasi')

@section('content')
    <a href="{{ route('subkategori.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Tambah Subklasifikasi
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Subklasifikasi</th>
                    <th>Klasifikasi</th>
                    <th class="text-center" style="width: 20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subkategori as $index => $s)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $s->nama }}</td>
                        <td>{{ $s->kategori->kategori ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('subkategori.edit', $s->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('subkategori.destroy', $s->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus subkategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($subkategori->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">Belum ada subkategori.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection