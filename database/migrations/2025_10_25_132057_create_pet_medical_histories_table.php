<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pet_medical_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pet_id')->nullable();
            $table->unsignedBigInteger('shelter_pet_id')->nullable();
            $table->unsignedBigInteger('vet_id')->constrained('users')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->timestamps();

            // relations
            $table->foreign('pet_id')->references('id')->on('pets')->onDelete('cascade');
            $table->foreign('shelter_pet_id')->references('id')->on('shelter_pets')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pet_medical_histories');
    }
};
