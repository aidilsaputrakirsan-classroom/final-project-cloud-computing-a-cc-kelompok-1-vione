<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    // Jika nama tabel di database Anda 'pets', ini opsional karena Laravel otomatis menebaknya.
    protected $table = 'pets';

    protected $fillable = [
        'pet_name', // ✅ WAJIB: Harus 'pet_name' (sesuai kolom DB), bukan 'name'
        'species',
        'breed',
        'age',
        'gender',
        'medical_info',
        'health_status', 
        'photo',
        'owner_id',
    ];

    // Relasi ke Owner (User)
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Relasi ke Appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'pet_id');
    }

    // Relasi ke Medical History
    public function medicalHistories()
    {
        return $this->hasMany(PetMedicalHistory::class, 'pet_id');
    }
}