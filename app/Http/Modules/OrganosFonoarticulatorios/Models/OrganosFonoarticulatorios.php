<?php

namespace App\Http\Modules\OrganosFonoarticulatorios\Models;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganosFonoarticulatorios extends Model
{
    use HasFactory;

    protected $fillable = [
        'lengua',
        'paladar',
        'labios',
        'mucosa',
        'amigdalas_palatinas',
        'tono',
        'timbre',
        'volumen',
        'modo_respiratorio',
        'tipo_respiratorio',
        'evaludacion_postural',
        'rendimiento_vocal',
        'prueba_de_glatzel',
        'golpe_glotico',
        'conducto_auditivo_externo',
        'consulta_id'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'consulta_id');
    }
}
