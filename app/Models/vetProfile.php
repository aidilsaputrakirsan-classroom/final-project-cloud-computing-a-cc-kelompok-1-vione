<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vetProfile extends Model
{
    protected $fillable=[
        'user_id',
     'specialization',
     'experience',
     'clinic_name',
     'contact',
     'available_days',
     'available_time',
     'about',
     'photo'
    ];


    public function user()
{
    return $this->belongsTo(User::class);
}

}
