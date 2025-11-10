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
    Schema::create('shelter_pets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('shelter_id')->constrained('users')->onDelete('cascade');
        $table->string('name');
        $table->string('species');
        $table->string('breed')->nullable();
        $table->integer('age')->nullable();
        $table->enum('gender', ['male', 'female', 'jantan', 'betina'])->nullable();
        $table->text('medical_info')->nullable();
        $table->string('photo')->nullable();
        $table->boolean('adopted')->default(false);
        
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shelter_pets');
    }
};
