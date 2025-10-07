<?php

namespace App\Http\Modules\TipoRutas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoRuta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion'
    ];
}
