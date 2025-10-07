<?php

namespace App\Http\Modules\RecomendacionesConsulta\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecomendacionesConsulta extends Model
{
    use HasFactory;

    protected $fillable = ['consulta_id', 'recomendaciones', 'user_registra_id', 'estado_id'];
}
