<?php

namespace App\Http\Modules\Historia\AntecedentesSexuales\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecedenteSexuale extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_antecedentes_sexuales',
        'tipo_orientacion_sexual',
        'tipo_identidad_genero',
        'resultado',
        'cuantos',
        'edad',
        'medico_registra',
        'consulta_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d'
    ];
}
