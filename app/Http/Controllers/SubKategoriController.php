<?php
namespace App\Http\Controllers;

use App\Models\Subkategori;
use App\Models\Kategori;
use Illuminate\Http\Request;

class SubkategoriController extends Controller
{
    public function index()
    {
        $subkategori = Subkategori::with('kategori')->get();
        return view('subkategori.index', compact('subkategori'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('subkategori.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama' => 'required|string|max:255',
        ]);

        Subkategori::create($request->all());

        return redirect()->route('subkategori.index')->with('success', 'Subkategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $subkategori = Subkategori::findOrFail($id);
        $kategori = Kategori::all();
        return view('subkategori.edit', compact('subkategori', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama' => 'required|string|max:255',
        ]);

        Subkategori::findOrFail($id)->update($request->all());

        return redirect()->route('subkategori.index')->with('success', 'Subkategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Subkategori::findOrFail($id)->delete();
        return redirect()->route('subkategori.index')->with('success', 'Subkategori berhasil dihapus.');
    }
}
