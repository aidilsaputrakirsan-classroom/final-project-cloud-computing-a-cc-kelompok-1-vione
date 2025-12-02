<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah super admin sudah ada biar tidak duplikat
        if (!User::where('email', 'superadmin@gmail.com')->exists()) {
            User::create([
                'name' => 'Super Administrator',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('password123'), // Ganti password sesukamu
                'role' => 'super_admin', // Role baru khusus
                'email_verified_at' => now(),
            ]);
        }
    }
}