<?php

use App\Http\Controllers\TransaksiBarangController;
use App\Http\Middleware\DirectLogin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SubKategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LaporanController;

// =======================
// 🔓 Public Routes
// =======================

// Halaman Welcome
Route::get('/', fn () => view('welcome'))->middleware(DirectLogin::class);

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =======================
// 🔐 Protected Routes
// =======================
Route::middleware(['auth'])->group(function () {

    // 🧭 Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [DashboardController::class, 'getData'])->name('dashboard.data');

    // 📦 Kategori & Subkategori
    Route::resource('/kategori', KategoriController::class);
    Route::resource('/subkategori', SubkategoriController::class);

    // 🔄 Ambil subkategori secara dinamis (AJAX)
    Route::get('/get-subkategori/{kategori_id}', function ($kategori_id) {
        return \App\Models\Subkategori::where('kategori_id', $kategori_id)->get();
    });

    // 📋 Barang CRUD
    Route::resource('/barang', BarangController::class);

    // 📜 Transaksi Barang
    Route::resource('/transaksibarang', TransaksiBarangController::class);

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});
