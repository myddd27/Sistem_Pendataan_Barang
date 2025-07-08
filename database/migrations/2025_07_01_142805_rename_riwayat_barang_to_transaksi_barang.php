<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ganti nama tabel dari riwayat_barang ke transaksi_barang
        Schema::rename('riwayat_barang', 'transaksi_barang');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan nama tabel jika di-rollback
        Schema::rename('transaksi_barang', 'riwayat_barang');
    }
};
