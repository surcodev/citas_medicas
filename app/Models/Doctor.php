<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'speciality_id',
        'medical_license_number',
        'biography'
    ];

    // RELACIONES INVERSA
    public function User(){
        return $this->belongsTo(User::class);
    }
    public function speciality(){
        return $this->belongsTo(Speciality::class);
    }
}
