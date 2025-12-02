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
        // Tambahkan kolom photo jika belum ada
        if (!Schema::hasColumn('vet_profiles', 'photo')) {
            $table->string('photo')->nullable()->after('about');
        }
    });
}

public function down(): void
{
    Schema::table('vet_profiles', function (Blueprint $table) {
        $table->dropColumn('photo');
    });
}

};
