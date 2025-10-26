<?php

namespace App\Models;

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
        'current_medications',
        'habits',
        'blood_pressure',
        'heart_rate',
        'respiratory_rate',
        'temperature',
        'stature',
        'weight',

        // Contactos de emergencia
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',

        'emergency_contact_name2',
        'emergency_contact_phone2',
        'emergency_contact_relationship2',

        'emergency_contact_name3',
        'emergency_contact_phone3',
        'emergency_contact_relationship3',
    ];

    /** RELACIONES **/

    // Relación inversa (1 paciente pertenece a 1 usuario)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación inversa (1 paciente pertenece a 1 tipo de sangre)
    public function bloodType()
    {
        return $this->belongsTo(BloodType::class);
    }

    // Relación polimórfica (1 paciente puede tener muchas imágenes)
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
