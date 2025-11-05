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
    Schema::table('vet_profiles', function (Blueprint $table) {
        $table->string('available_days')->nullable();  // e.g. Monday,Tuesday
        $table->string('available_time')->nullable();  // e.g. 10:00 AM - 5:00 PM
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vet_profiles', function (Blueprint $table) {
            //
        });
    }
};
