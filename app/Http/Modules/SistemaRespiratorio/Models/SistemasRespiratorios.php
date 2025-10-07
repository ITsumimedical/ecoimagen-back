<?php

namespace App\Http\Modules\SistemaRespiratorio\Models;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SistemasRespiratorios extends Model
{
    use HasFactory;

    protected $fillable = [
        'consulta_id',
        'creado_por',
        'escala_disnea_mrc',
        'indice_bode',
        'bodex',
        'escala_de_epworth',
        'escala_de_borg',
        'evaluacion_cat',
        'stop_bang'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
