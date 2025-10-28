<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_users');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('no_telepon');
            $table->string('foto_users')->nullable();
            $table->enum('roles', ['admin', 'petugas', 'pasien']);
            $table->rememberToken();
            $table->timestamps();
        });

        // Create poliklinik table
        Schema::create('poliklinik', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('nama_poliklinik');
            $table->timestamps();
        });

        // Create dokter table
        Schema::create('dokter', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dokter');
            $table->foreignId('poliklinik_id')->constrained('poliklinik')->onDelete('cascade');
            $table->string('foto_dokter')->nullable();
            $table->timestamps();
        });

        // Create datahewan table
        Schema::create('datahewan', function (Blueprint $table) {
            $table->id();
            $table->string('foto_hewan')->nullable();
            $table->string('nama_hewan');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['jantan', 'betina'])->nullable();
            $table->text('alamat')->nullable();
            $table->foreignId('users_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datahewan');
        Schema::dropIfExists('dokter');
        Schema::dropIfExists('poliklinik');
        Schema::dropIfExists('users');
    }
};
