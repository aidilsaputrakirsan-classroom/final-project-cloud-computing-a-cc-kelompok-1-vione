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
        // Create user table
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('nama_user');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('no_telepon');
            $table->string('foto_user')->nullable();
            $table->enum('roles', ['admin', 'petugas', 'hewan']);
            $table->rememberToken();
            $table->timestamps();
        });

        // Create layanan table
        Schema::create('layanan', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('nama_layanan');
            $table->timestamps();
        });

        // Create dokter table
        Schema::create('dokter', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dokter');
            $table->foreignId('layanan_id')->constrained('layanan')->onDelete('cascade');
            $table->string('foto_dokter')->nullable();
            $table->timestamps();
        });

        // Create datahewan table
        Schema::create('datahewan', function (Blueprint $table) {
            $table->id();
            $table->string('hewan')->nullable();
            $table->string('nik')->nullable();
            $table->string('nama_hewan');
            $table->string('email');
            $table->string('no_telp');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable();
            $table->text('alamat')->nullable();
                      $table->foreignId('user_id')->constrained('user');
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
        Schema::dropIfExists('layanan');
        Schema::dropIfExists('user');
    }
};
