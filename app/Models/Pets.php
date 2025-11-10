<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pets extends Model
{
    protected $fillable=[
  'pet_name',
  'age',
  'gender',
  'breed',
  'species',
  'medical_info',
  'status',
  'photo',
  'owner_id',

    ];
    
    public function user(){
        return $this->belongsTo(User::class,'owner_id');
    }
    public function medicalHistories()
{
    return $this->hasMany(PetMedicalHistory::class, 'pet_id');
}

}
