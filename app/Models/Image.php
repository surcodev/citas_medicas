<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = [
        'path',
        'size',
        'imageable_id',
        'imageable_type',
    ];

    protected $appends = ['url']; // 👈 para incluirlo en JSON

    public function imageable()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        // Devuelve la ruta pública del archivo almacenado en storage/app/public
        return asset('storage/' . $this->path);
    }

}
