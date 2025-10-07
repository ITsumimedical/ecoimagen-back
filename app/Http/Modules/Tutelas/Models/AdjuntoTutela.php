<?php

namespace App\Http\Modules\Tutelas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntoTutela extends Model
{
    protected $fillable = ['ruta', 'actuacion_tutela_id', 'nombre', 'respuesta_id'];
    use HasFactory;
}
