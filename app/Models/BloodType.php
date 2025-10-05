<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodType extends Model
{
    // RELACIONES UNO A MUCHOS (1-M)
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function bloodType(){
        return $this->belongsTo(BloodType::class);
    }
}
