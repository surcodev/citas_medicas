<?php

namespace App\Models;

use Faker\Core\Blood;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{

    protected $fillable = [
        'user_id',
        'blood_type_id',
        'allergies',
        'chronic_conditions',
        'surgical_history',
        'family_history',
        'observations',
        'emergency_contact_name',
        'emergency_contact_phone',
        'stature',
        'weight',
        'emergency_contact_relationship',
    ];

    // RELACIONES INVERSA (1-1) 
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function bloodType(){
        return $this->belongsTo(BloodType::class);
    }
}
