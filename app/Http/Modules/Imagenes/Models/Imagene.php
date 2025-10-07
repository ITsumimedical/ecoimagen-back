<?php

namespace App\Http\Modules\Imagenes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagene extends Model
{
    use HasFactory;

    protected $fillable = ['ruta','nombre','entidad_id','nombre_imagen'];
}
