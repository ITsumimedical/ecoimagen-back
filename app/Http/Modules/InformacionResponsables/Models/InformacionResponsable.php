<?php

namespace App\Http\Modules\InformacionResponsables\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformacionResponsable extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_completo',
        'telefono',
        'celular',
        'direccion',
        'parentesco',
        'ingreso_domiciliario_id'
    ];

}
