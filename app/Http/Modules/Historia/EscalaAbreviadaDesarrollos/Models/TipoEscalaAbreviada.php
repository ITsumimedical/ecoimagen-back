<?php

namespace App\Http\Modules\Historia\EscalaAbreviadaDesarrollos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEscalaAbreviada extends Model
{
    use HasFactory;
    protected $table = 'tipo_escala_abreviada';
    protected $fillable = [
        'id',
        'nombre'
    ];
}
