<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Users extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Nama tabel yang digunakan oleh model ini.
     *
     * @var string
     */
    protected $table = 'users'; // karena nama tabel kamu bukan 'userss'

    /**
     * Kolom yang bisa diisi mass-assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_users',
        'username',
        'password',
        'no_telepon',
        'foto_users',
        'roles',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi (misalnya ke JSON).
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Konversi otomatis tipe data.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];
}
