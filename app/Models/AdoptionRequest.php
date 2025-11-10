<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'pet_id',
        'shelter_id',
        'status',
        
    ];

    // 🐾 Relationship with Owner (User)
   public function pet()
{
    return $this->belongsTo(\App\Models\ShelterPet::class, 'pet_id');
}

public function owner()
{
    return $this->belongsTo(\App\Models\User::class, 'owner_id');
}

public function shelter()
{
    return $this->belongsTo(\App\Models\User::class, 'shelter_id');
}

}
