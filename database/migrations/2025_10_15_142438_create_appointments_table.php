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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            // Relasi ke pets (wajib ada)
            $table->unsignedBigInteger('pet_id')->nullable();

            // Relasi ke vet (sesuaikan jika kolom berbeda)
            $table->unsignedBigInteger('vet_profile_id')->nullable();

            // Relasi ke owner/user
            $table->foreignId('owner_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            // Waktu janji temu
            $table->dateTime('appointment_time')->nullable();

            // Status janji temu
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
