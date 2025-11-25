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
            // Menambahkan kolom date dan time
            // Gunakan nullable() agar data lama (jika ada) tidak error
            $table->date('date')->nullable()->after('vet_id');
            $table->string('time')->nullable()->after('date'); 
            
            // Tambahkan kolom message jika belum ada (opsional, untuk jaga-jaga)
            if (!Schema::hasColumn('appointments', 'message')) {
                $table->text('message')->nullable()->after('time');
            }
            
            // Tambahkan status jika belum ada
             if (!Schema::hasColumn('appointments', 'status')) {
                $table->string('status')->default('Pending')->after('message');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['date', 'time']);
            // Hapus kolom lain jika ditambahkan di atas
            if (Schema::hasColumn('appointments', 'message')) {
                $table->dropColumn('message');
            }
            if (Schema::hasColumn('appointments', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};