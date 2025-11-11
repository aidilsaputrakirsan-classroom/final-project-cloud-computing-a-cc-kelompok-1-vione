<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
protected $fillable=[
    'owner_id',
    'vet_id',
    'date',
    'time',
    'message',
    'status',
    'pet_id',
     'shelter_pet_id' 
];

public function owner(){
    return $this->belongsTo(User::class,'owner_id');
}
public function vet()
{
    return $this->belongsTo(User::class, 'vet_id');
}
public function pet()
{
    return $this->belongsTo(Pets::class, 'pet_id');
}
public function shelterPet() {
    return $this->belongsTo(\App\Models\adoption_pets::class, 'shelter_pet_id');
}
public function medicalHistory()
{
    return $this->hasMany(\App\Models\PetMedicalHistory::class, 'pet_id', 'pet_id');
}
}
