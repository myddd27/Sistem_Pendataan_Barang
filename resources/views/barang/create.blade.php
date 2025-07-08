@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                        @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kode Barang</label>
                        <input type="text" name="kode" class="form-control" value="{{ old('kode') }}" required>
                        @error('kode') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="col-md-6">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" id="kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Subkategori --}}
                    <div class="col-md-6">
                        <label class="form-label">Subkategori</label>
                        <select name="subkategori_id" id="subkategori" class="form-select" required>
                            <option value="">-- Pilih Subkategori --</option>
                            {{-- Akan diisi via JavaScript --}}
                        </select>
                        @error('subkategori_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" value="{{ old('stok', 0) }}" required>
                        @error('stok') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Satuan</label>
                        <input type="text" name="satuan" class="form-control" value="{{ old('satuan') }}" required>
                        @error('satuan') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Harga</label>
                        <input type="text" name="harga" id="harga" class="form-control" value="{{ old('harga') }}"
                            placeholder="Rp 1.000.000" required>
                        @error('harga') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const hargaInput = document.getElementById('harga');
        hargaInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            value = new Intl.NumberFormat('id-ID').format(value);
            e.target.value = 'Rp ' + value;
        });

        const kategoriSelect = document.getElementById('kategori');
        const subkategoriSelect = document.getElementById('subkategori');

        kategoriSelect.addEventListener('change', function () {
            const kategoriId = this.value;

            // Bersihkan subkategori
            subkategoriSelect.innerHTML = '<option value="">-- Pilih Subkategori --</option>';

            if (!kategoriId) return;

            fetch(`/get-subkategori/${kategoriId}`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(sub => {
                        const opt = document.createElement('option');
                        opt.value = sub.id;
                        opt.textContent = sub.nama;
                        subkategoriSelect.appendChild(opt);
                    });
                });
        });
    </script>
@endsection
