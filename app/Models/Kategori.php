<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Subkategori;

class Kategori extends Model
{
    
    protected $table = 'kategori';

    protected $fillable = ['kategori'];

    public function subkategori()
    {
        return $this->hasMany(Subkategori::class);
    }

    // Tambahkan relasi ini:
    public function barang()
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }

}



