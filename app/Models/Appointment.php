<?php

namespace App\Models;

use App\Enums\AppointmentEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date',
        'start_time',
        'end_time',
        'duration',
        'reason',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'status' => AppointmentEnum::class,
    ];

    // ACCESORES
    public function start(): Attribute
    {
        return Attribute::make(
            get: function(){
                $date = $this->date->format('Y-m-d');
                $time = $this->start_time->format('H:i:s');

                // RETORNAR ENFORMATO  ISO 8601
                return Carbon::parse("{$date} {$time}")->toIso8601String();
            }
        );
    }

    public function end(): Attribute
    {
        return Attribute::make(
            get: function(){
                $date = $this->date->format('Y-m-d');
                $time = $this->end_time->format('H:i:s');

                // RETORNAR ENFORMATO  ISO 8601
                return Carbon::parse("{$date} {$time}")->toIso8601String();
            }
        );
    }

    //RELACION UNO A UNO
    public function consultation()
    {
       return $this->hasOne(Consultation::class);
    }

    //RELACIONES INVERSAS
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
