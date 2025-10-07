<?php

namespace App\Http\Modules\Audit\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class audit extends Model
{
    use HasFactory;

    protected $fillable = [
        'frecuencia_consume_alcohol',
        'cuantas_bebidas_consume_en_dia',
        'frecuencia_toma_5_o_mas_bebidas_alcoholicas',
        'frecuencia__incapaz_beber',
        'frecuencia_no_atiende_obligaciones',
        'frecuencia__necesitado_beber_ayunas',
        'frecuencia_remordimientos_sentimientos_luego_beber',
        'frecuencia_no_recuerda_sucedido_noche_anterior',
        'persona_herida_por_beber',
        'familiar_amigo_muestra_preocupacion_por_consumo',
        'consulta_id',
        'interpretacion_resultados'
    ];

    public function consulta() {
        return $this->belongsTo(Consulta::class);
    }
}
