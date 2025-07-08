<?php

namespace App\Http\Controllers;

use App\Models\TransaksiBarang;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiBarangController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiBarang::with(['barang', 'user'])->latest()->get();
        return view('transaksibarang.index', compact('transaksi'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('transaksibarang.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jenis' => 'required|in:Masuk,Keluar',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $barang = Barang::findOrFail($request->barang_id);

                // Validasi stok jika keluar
                if ($request->jenis === 'Keluar' && $barang->stok < $request->jumlah) {
                    throw new \Exception('Stok tidak mencukupi untuk pengeluaran ini.');
                }

                // Simpan riwayat
                TransaksiBarang ::create([
                    'barang_id' => $request->barang_id,
                    'jenis' => $request->jenis,
                    'jumlah' => $request->jumlah,
                    'tanggal' => $request->tanggal,
                    'keterangan' => $request->keterangan,
                    'users_id' => Auth::id(),
                ]);

                // Update stok barang
                if ($request->jenis === 'Masuk') {
                    $barang->stok += $request->jumlah;
                } else {
                    $barang->stok -= $request->jumlah;
                }

                $barang->save();
            });

            return redirect()->route('transaksibarang.index')->with('success', 'Transaksi barang berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['jumlah' => $e->getMessage()])
                ->withInput();
        }
    }
}
