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
        // PERBAIKAN: Hapus tabel lama dulu jika ada, supaya tidak error
        Schema::dropIfExists('activity_logs');

        // Baru buat tabelnya ulang
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('action'); // Contoh: "CREATE", "UPDATE", "DELETE"
            $table->text('description'); // Contoh: "Menambahkan hewan baru bernama Mochi"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};