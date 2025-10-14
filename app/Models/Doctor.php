<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'speciality_id',
        'medical_license_number',
        'biography',
        'active',
    ];

    // RELACIONES INVERSA
    public function User(){
        return $this->belongsTo(User::class);
    }
    public function speciality(){
        return $this->belongsTo(Speciality::class);
    }

    // RELACION UNO A MUCHOS
    public function schedules(){
        return $this->hasMany(Schedule::class);
    }

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
}
