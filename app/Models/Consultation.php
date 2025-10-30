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

    // Relación polimórfica (1 paciente puede tener muchas imágenes)
    public function images()
    {
        return $this->morphMany(Image2::class, 'imageable');
    }
}
