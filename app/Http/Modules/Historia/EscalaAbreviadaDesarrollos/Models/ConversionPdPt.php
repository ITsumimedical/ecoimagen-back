<?php

namespace App\Http\Modules\Historia\EscalaAbreviadaDesarrollos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversionPdPt extends Model
{
    use HasFactory;
    protected $table = 'conversion_pd_to_pt';
    protected $fillable = [
        'id',
        'puntuacion_directa',
        'rango',
        'puntuacion_total',
        'tipo_escala_abreviada_id',
        'resultado_final',
    ];

    public function tipoEscalaAbreviada()
    {
        return $this->belongsTo(TipoEscalaAbreviada::class, 'tipo_escala_abreviada_id');
    }


}
