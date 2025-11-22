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
            // Tambahkan kolom untuk pet milik 'owner'
            // Dibuat nullable() karena bisa jadi yang diisi adalah shelter_pet_id
            $table->foreignId('pet_id')
                  ->nullable()
                  ->after('vet_id') // Opsional, agar rapi
                  ->constrained('pets') // Asumsi nama tabel Anda 'pets'
                  ->onDelete('set null'); // Jika pet dihapus, ID di sini jadi null

            // Tambahkan kolom untuk pet milik 'shelter'
            // Dibuat nullable() karena bisa jadi yang diisi adalah pet_id
            $table->foreignId('shelter_pet_id')
                  ->nullable()
                  ->after('pet_id') // Opsional, agar rapi
                  ->constrained('shelter_pets') // Asumsi nama tabel Anda 'shelter_pets'
                  ->onDelete('set null'); // Jika shelter pet dihapus, ID jadi null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Hapus foreign key & kolom untuk shelter_pet_id
            $table->dropForeign(['shelter_pet_id']);
            $table->dropColumn('shelter_pet_id');

            // Hapus foreign key & kolom untuk pet_id
            $table->dropForeign(['pet_id']);
            $table->dropColumn('pet_id');
        });
    }
};