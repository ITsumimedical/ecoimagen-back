<?php

namespace App\Http\Modules\ClienteMesaAyuda\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientemesaayuda extends Model
{
    use HasFactory;

    protected $table = "cliente_mesa_ayudas";

    protected $fillable = [
        'nombre',
        'endpoint_pendiente',
        'endpoint_accion_comentario_solicitante',
        'endpoint_accion_reasignar',
        'endpoint_accion_solucionar'
    ];
}
