<?php

namespace App\Http\Modules\estructuraDinamica\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstructuraDinamicaFamiliar extends Model
{
    use HasFactory;

    protected $fillable = [
        'estructura_dinamica',
        'situacion_socioeconomica',
        'entorno_social',
        'riesgo_psicosocial',
        'consulta_id'
    ];
}
