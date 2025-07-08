<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->foreignId('subkategori_id')
                ->nullable()
                ->constrained('subkategori')
                ->onDelete('set null')
                ->after('kategori_id'); // simpan setelah kolom kategori_id
        });
    }

    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->dropForeign(['subkategori_id']);
            $table->dropColumn('subkategori_id');
        });
    }
};
