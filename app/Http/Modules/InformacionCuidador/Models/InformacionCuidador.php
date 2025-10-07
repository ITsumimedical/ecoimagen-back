<?php

namespace App\Http\Modules\InformacionCuidador\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformacionCuidador extends Model
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
