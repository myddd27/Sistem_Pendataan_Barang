<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\TransaksiBarang;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Ringkasan Total ---
        $totalBarang   = Barang::count();
        $totalKategori = Kategori::count();
        $barangMasuk   = TransaksiBarang::where('jenis', 'Masuk')->sum('jumlah');
        $barangKeluar  = TransaksiBarang::where('jenis', 'Keluar')->sum('jumlah');

        // --- Grafik Barang Masuk & Keluar (7 Hari Terakhir) ---
        $grafikTanggal   = collect();
        $grafikMasuk     = collect();
        $grafikKeluar    = collect();

        for ($i = 6; $i >= 0; $i--) {
            $tgl = Carbon::now()->subDays($i)->format('Y-m-d');
            $grafikTanggal->push($tgl);

            $masuk = TransaksiBarang::whereDate('tanggal', $tgl)->where('jenis', 'Masuk')->sum('jumlah');
            $keluar = TransaksiBarang::whereDate('tanggal', $tgl)->where('jenis', 'Keluar')->sum('jumlah');

            $grafikMasuk->push($masuk);
            $grafikKeluar->push($keluar);
        }

        // --- Grafik Distribusi Kategori ---
        $labelKategori   = [];
        $jumlahKategori = [];

        $kategoriList = Kategori::withCount('barang')->get();
        foreach ($kategoriList as $kategori) {
            $labelKategori[]   = $kategori->kategori;
            $jumlahKategori[] = $kategori->barang_count;
        }

        // --- Riwayat Transaksi Terbaru ---
        $riwayatTerbaru = TransaksiBarang::with('barang')
                            ->orderByDesc('tanggal')
                            ->take(10)
                            ->get();

        // --- Kirim ke View ---
        return view('dashboard', compact(
            'totalBarang',
            'totalKategori',
            'barangMasuk',
            'barangKeluar',
            'grafikTanggal',
            'grafikMasuk',
            'grafikKeluar',
            'labelKategori',
            'jumlahKategori',
            'riwayatTerbaru'
        ));
    }
}
