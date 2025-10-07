<?php

namespace App\Http\Modules\Eventos\Adjunto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntoEventoAdverso extends Model
{
    protected $fillable = ['ruta', 'nombre', 'evento_id', 'accion_mejora_id'];

    use HasFactory;

}
