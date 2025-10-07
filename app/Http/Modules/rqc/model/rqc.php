<?php

namespace App\Http\Modules\rqc\model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rqc extends Model
{
    use HasFactory;

    protected $fillable = [
        'lenguaje_normal',
        'duerme_mal',
        'tenido_convulsiones',
        'dolores_cabeza',
        'huido_casa',
        'robado_casa',
        'nervioso',
        'lento_responder',
        'no_juega_amigos',
        'orina_defeca',
        'consulta_id',
        'interpretacion_resultado'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
