<?php

namespace App\Http\Modules\NotasEnfermeria\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotasEnfermeria extends Model
{
    use HasFactory;

    protected $fillable = ['nota','signos_alarma','cuidados_casa','caso_urgencias','alimentacion','efectos_secundarios','habito_higiene',
                            'derechos_deberes','normas_sala_quimioterapia','orden_id','user_id'];
}
