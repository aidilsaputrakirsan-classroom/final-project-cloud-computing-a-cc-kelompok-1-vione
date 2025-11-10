<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // 🐕 Relationship: PetMedicalHistory (optional — if vets treat shelter pets too)
    public function medicalHistories()
    {
        return $this->hasMany(PetMedicalHistory::class, 'pet_id');
    }
    public function appointments()
{
    return $this->hasMany(\App\Models\Appointments::class, 'shelter_pet_id');
}

}
