<?php

namespace App\Http\Controllers;

use App\Models\TransaksiBarang;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = TransaksiBarang::with([
            'barang.kategori',
            'barang.subkategori',
            'user'
        ])->orderBy('tanggal', 'desc')->get();

        return view('laporan.index', compact('laporan'));
    }
}
