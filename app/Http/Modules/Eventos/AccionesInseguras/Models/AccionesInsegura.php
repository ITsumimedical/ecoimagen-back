<?php

namespace App\Http\Modules\Eventos\AccionesInseguras\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccionesInsegura extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre', 'condiciones_paciente', 'metodos', 'colaborador',
        'equipo_trabajo', 'ambiente', 'recursos', 'contexto', 'analisis_evento_id'
    ];

    protected $casts = [
        'condiciones_paciente' => 'array',
        'metodos' => 'array',
        'colaborador' => 'array',
        'equipo_trabajo' => 'array',
        'ambiente' => 'array',
        'recursos' => 'array',
        'contexto' => 'array',
    ];
}
