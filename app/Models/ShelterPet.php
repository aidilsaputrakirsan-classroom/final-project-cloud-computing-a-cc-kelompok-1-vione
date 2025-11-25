<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Appointment; // ✅ Import model singular

class ShelterPet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'species',
        'breed',
        'age',
        'gender',
        'medical_info',
        'photo',
        'status',
        'shelter_id',
    ];

    // 🏠 Relationship: Shelter (User)
    public function shelter()
    {
        return $this->belongsTo(User::class, 'shelter_id');
    }

    // 🐕 Relationship: PetMedicalHistory
    public function medicalHistories()
    {
        return $this->hasMany(PetMedicalHistory::class, 'shelter_pet_id'); 
        // Note: Biasanya field foreign key-nya 'shelter_pet_id' jika ini untuk hewan shelter, 
        // bukan 'pet_id' (yang biasanya untuk hewan milik owner).
    }

    // 📅 Relationship: Appointments
    public function appointments()
    {
        // ✅ PERBAIKAN: Menggunakan Appointment (Singular)
        return $this->hasMany(Appointment::class, 'shelter_pet_id');
    }
}