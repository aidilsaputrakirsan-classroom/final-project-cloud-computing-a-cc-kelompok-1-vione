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
    Schema::create('pets', function (Blueprint $table) {
        $table->id();
        $table->string('pet_name');
        $table->integer('age')->nullable();
        $table->enum('gender', ['male', 'female'])->nullable();
        $table->string('breed')->nullable();
        $table->string('species')->nullable();
        $table->text('medical_info')->nullable();
        $table->enum('status', ['active', 'adopted', 'deceased'])->default('active');
        $table->string('photo')->nullable();
        $table->foreignId('owner_id')
              ->constrained('users')
              ->onDelete('cascade')
              ->onUpdate('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
