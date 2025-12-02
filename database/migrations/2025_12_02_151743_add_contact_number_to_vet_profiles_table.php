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
        // Menambahkan kolom contact_number setelah kolom clinic_name (opsional)
        $table->string('contact_number')->nullable()->after('clinic_name'); 
    });
}

public function down(): void
{
    Schema::table('vet_profiles', function (Blueprint $table) {
        $table->dropColumn('contact_number');
    });
}

};
