<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Subkategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with('subkategori.kategori')->get();
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('barang.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:barang,kode',
            'subkategori_id' => 'required|exists:subkategori,id',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'harga' => 'required',
        ]);

        $request->merge([
            'harga' => preg_replace('/\D/', '', $request->harga),
        ]);

        Barang::create($request->all());

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $barang = Barang::with('subkategori.kategori')->findOrFail($id);
        $kategori = Kategori::all();

        // Jika barang punya subkategori, ambil subkategori sesuai kategori-nya
        $subkategori = $barang->subkategori
            ? Subkategori::where('kategori_id', $barang->subkategori->kategori_id)->get()
            : Subkategori::all();

        return view('barang.edit', compact('barang', 'kategori', 'subkategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:barang,kode,' . $id,
            'subkategori_id' => 'required|exists:subkategori,id',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'harga' => 'required',
        ]);

        $request->merge([
            'harga' => preg_replace('/\D/', '', $request->harga),
        ]);

        if (!is_numeric($request->harga)) {
            return back()->withErrors(['harga' => 'Harga tidak valid.'])->withInput();
        }

        Barang::findOrFail($id)->update($request->all());

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
