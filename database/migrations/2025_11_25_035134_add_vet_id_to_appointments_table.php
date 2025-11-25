<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // 1. Menambahkan kolom vet_id
            // 'nullable()' penting agar data lama tidak error
            // 'after' agar posisi kolom rapi (setelah owner_id)
            $table->unsignedBigInteger('vet_id')->nullable()->after('owner_id');

            // 2. Menambahkan Foreign Key Constraint
            // Ini menghubungkan vet_id ke id di tabel users
            // onDelete('cascade') berarti jika user (dokter) dihapus, janji temu ikut terhapus
            $table->foreign('vet_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu
            // Format nama biasanya: nama_tabel_nama_kolom_foreign
            $table->dropForeign(['vet_id']);

            // Kemudian hapus kolomnya
            $table->dropColumn('vet_id');
        });
    }
};