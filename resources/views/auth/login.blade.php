@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
    <div class="text-center mb-4">
        <i class="bi bi-box-seam-fill fs-1 text-primary"></i>
        <h4 class="fw-bold mt-2">Sistem Barang Logistik</h4>
        <p class="text-muted small">Silakan masuk untuk mengelola sistem</p>
    </div>

    <form method="POST" action="{{ url('/login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger small py-2 px-3">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
            </button>
        </div>
    </form>

    <p class="text-center mt-4 text-muted small mb-0">
        &copy; {{ date('Y') }} Sistem Barang Logistik
    </p>
</div>
@endsection
