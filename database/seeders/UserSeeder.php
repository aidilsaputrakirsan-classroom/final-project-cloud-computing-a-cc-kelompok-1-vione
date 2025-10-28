<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Users;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel users.
     */
    public function run(): void
    {
        // Data default pengguna
        $users = [
            [
                'nama_users' => 'Administrator',
                'username' => 'admin@pawcare.com',
                'password' => Hash::make('admin123'),
                'no_telepon' => '0812345678',
                'roles' => 'admin',
            ],
            [
                'nama_users' => 'Petugas Test',
                'username' => 'petugas@pawcare.com',
                'password' => Hash::make('petugas123'),
                'no_telepon' => '0812345679',
                'roles' => 'petugas',
            ],
            [
                'nama_users' => 'Pasien Test',
                'username' => 'pemilikhewan@pawcare.com',
                'password' => Hash::make('pemilikhewan123'),
                'no_telepon' => '0812345670',
                'roles' => 'pasien',
            ],
        ];

        // Insert jika belum ada (supaya tidak duplikat)
        foreach ($users as $data) {
            Users::firstOrCreate(
                ['username' => $data['username']], // kunci unik
                $data
            );
        }
    }
}
