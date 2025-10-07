<?php

namespace App\Http\Modules\testMchat\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mChat extends Model
{
    use HasFactory;
    protected $fillable = [
        'señala_mira',
        'sordo',
        'juegos_fantasia',
        'se_sube_cosas',
        'movimientos_inusuales_dedos',
        'señala_cosas_fuera_alcance',
        'muestra_llama_atencion',
        'interesa_otros_niños',
        'muestra_cosas_acercandolas',
        'responde_llamado_nombre',
        'sonrie_el_tambien',
        'molestan_ruidos_cotidianos',
        'camina_solo',
        'mira_ojos_cuando_habla',
        'imita_movimientos',
        'gira_mirar_usted_mira',
        'intenta_hagan_cumplidos',
        'entiende_ordenes',
        'mira__reacciones',
        'gusta_juegos_movimientos',
        'consulta_id',
        'interpretacion_resultado'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
