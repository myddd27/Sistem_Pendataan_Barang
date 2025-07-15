<?php

namespace App\Http\Controllers;

use App\Models\TransaksiBarang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = TransaksiBarang::with([
            'barang.kategori',
            'barang.subkategori',
            'user'
        ])->orderBy('tanggal', 'desc');

        // Filter berdasarkan tipe waktu dan tanggal
        $tipe = $request->input('tipe_waktu');
        $tanggal = null;

        if ($tipe === 'harian') {
            $tanggal = $request->input('tanggal');
        } elseif ($tipe === 'mingguan') {
            $tanggal = $request->input('minggu');
        } elseif ($tipe === 'bulanan') {
            $tanggal = $request->input('bulan');
        }

        if (!empty($tanggal) && !empty($tipe)) {
            $tanggal = Carbon::parse($tanggal);

            if ($tipe === 'harian') {
                $query->whereDate('tanggal', $tanggal);
            } elseif ($tipe === 'mingguan') {
                $start = $tanggal->copy()->startOfWeek(); // Senin
                $end = $tanggal->copy()->endOfWeek();     // Minggu
                $query->whereBetween('tanggal', [$start, $end]);
            } elseif ($tipe === 'bulanan') {
                $query->whereMonth('tanggal', $tanggal->month)
                    ->whereYear('tanggal', $tanggal->year);
            }
        }


        $laporan = $query->get();

        return view('laporan.index', compact('laporan'));
    }
}
