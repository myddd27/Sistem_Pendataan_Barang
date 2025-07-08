<?php

namespace App\Http\Controllers;

use App\Models\TransaksiBarang;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = TransaksiBarang::with([
            'barang.kategori',
            'barang.subkategori',
            'user'
        ])->orderBy('tanggal', 'desc');

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $laporan = $query->get();

        return view('laporan.index', compact('laporan'));
    }
}
