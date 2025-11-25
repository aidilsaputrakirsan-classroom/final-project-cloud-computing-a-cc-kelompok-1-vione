<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'owner_id',
        'vet_id',
        'date',
        'time',
        'message',
        'status',
        'pet_id',           // Untuk hewan milik Owner
        'shelter_pet_id',   // Untuk hewan milik Shelter
        'vet_feedback'      // Feedback dari dokter (opsional)
    ];

    // Relasi ke User (Owner/Pembuat Janji)
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Relasi ke User (Dokter Hewan)
    public function vet()
    {
        return $this->belongsTo(User::class, 'vet_id');
    }

    // Relasi ke Pet (Milik Owner Perorangan)
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }

    // ✅ PENTING: Relasi ke Shelter Pet (Milik Shelter)
    // Ini yang membuat nama hewan shelter muncul
    public function shelterPet()
    {
        return $this->belongsTo(ShelterPet::class, 'shelter_pet_id');
    }

    // Relasi ke Medical History (Opsional)
    public function medicalHistory()
    {
        return $this->hasMany(PetMedicalHistory::class, 'pet_id', 'pet_id'); // Sesuaikan foreign key jika perlu
    }
}