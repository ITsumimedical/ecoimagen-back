<?php

namespace App\Http\Modules\SaludOcupacional\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaludOcupacional extends Model
{
    use HasFactory;

    protected $fillable = [
        'consulta_id',
        'tipo_examen',
        'tipo_consulta',
        'enfermedad_actual',
    ];
}
