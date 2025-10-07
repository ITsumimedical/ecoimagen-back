<?php

namespace App\Http\Modules\RxFinal\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RxFinal extends Model
{
    use HasFactory;

    protected $fillable = [
        'esfera_ojo_derecho',
        'esfera_ojo_izquierdo',
        'cilindro_ojo_derecho',
        'cilindro_ojo_izquierdo',
        'eje_ojo_derecho',
        'eje_ojo_izquierdo',
        'add_ojo_derecho',
        'add_ojo_izquierdo',
        'prima_base_ojo_derecho',
        'prima_base_ojo_izquierdo',
        'grados_ojo_derecho',
        'grados_ojo_izquierdo',
        'av_lejos_ojo_derecho',
        'av_lejos_ojo_izquierdo',
        'av_cerca_ojo_derecho',
        'av_cerca_ojo_izquierdo',
        'tipo_lentes',
        'detalle',
        'altura',
        'color_ttos',
        'dp',
        'uso',
        'control',
        'duracion_vigencia',
        'observaciones',
        'consulta_id'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
