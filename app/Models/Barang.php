<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = [
        'nama',
        'kode',
        'kategori_id',
        'subkategori_id', // ← INI WAJIB ADA
        'stok',
        'satuan',
        'harga',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function subkategori()
    {
        
        return $this->belongsTo(Subkategori::class);
    }

}
