<?php

namespace App\Http\Modules\AuditoriaAlertas\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class auditoriaAlertas extends Model
{
    use HasFactory;

    protected $fillable = [ 'acepto', 'alerta_detalle_id', 'usuario_registra_id','consulta_id','estado_alerta_id'];
}
