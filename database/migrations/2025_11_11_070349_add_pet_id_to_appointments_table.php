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
            // Menambahkan kolom 'pet_id'
            // Ini akan terhubung ke kolom 'id' di tabel 'pets'
            $table->foreignId('pet_id')
                  ->after('vet_id') // Opsional, agar rapi setelah kolom vet_id
                  ->constrained('pets') // Menetapkan foreign key ke tabel 'pets'
                  ->onDelete('cascade'); // Jika pet dihapus, appointment juga ikut terhapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Ini penting agar migrasi bisa di-rollback
            $table->dropForeign(['pet_id']);
            $table->dropColumn('pet_id');
        });
    }
};