<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetMedicalHistory extends Model
{
    use HasFactory;

    protected $fillable = ['pet_id', 'shelter_pet_id', 'vet_id', 'notes'];

    public function vet()
    {
        return $this->belongsTo(User::class, 'vet_id');
    }

    public function pet()
    {
        return $this->belongsTo(Pets::class, 'pet_id');
    }

    public function shelterPet()
    {
        return $this->belongsTo(ShelterPet::class, 'shelter_pet_id');
    }
}
