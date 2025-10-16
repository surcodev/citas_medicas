<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'appointment_id',
        'diagnosis',
        'treatment',
        'notes',
        'prescriptions',
    ];

    protected $casts = [
        'prescriptions' => 'json',
    ];

    //RELACION INVERSA CON APPOINTMENT
    public function appointment()
    {
       return $this->belongsTo(Appointment::class);
    }
}
