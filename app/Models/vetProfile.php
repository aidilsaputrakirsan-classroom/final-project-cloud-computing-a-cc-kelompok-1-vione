<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VetProfile extends Model
{
    use HasFactory;

    protected $table = 'vet_profiles'; // Pastikan nama tabel di database sesuai

    // DAFTARKAN SEMUA KOLOM DARI CONTROLLER DI SINI
    protected $fillable = [
        'user_id',
        'specialization',
        'experience',
        'clinic_name',
        'contact_number',
        'available_days',
        'available_time',
        'about',
        'photo', // Jangan lupa ini agar foto bisa tersimpan
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}