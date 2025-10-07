<?php

namespace App\Http\Modules\valoracionAntropometrica\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValoracionAntropometrica extends Model
{
    use HasFactory;

    protected $fillable = [
        'peso_anterior',
        'fecha_registro_peso_anterior',
        'peso_actual',
        'altura_actual',
        'imc',
        'clasificacion',
        'perimetro_braquial',
        'pliegue_grasa_tricipital',
        'pliegue_grasa_subescapular',
        'peso_talla',
        'longitud_talla',
        'consulta_id'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
