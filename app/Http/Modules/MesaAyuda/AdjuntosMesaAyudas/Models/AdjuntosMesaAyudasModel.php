<?php

namespace App\Http\Modules\MesaAyuda\AdjuntosMesaAyudas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntosMesaAyudasModel extends Model
{
    use HasFactory;

    protected $table = 'adjuntos_mesa_ayudas';

    protected $fillable = [ 'nombre', 'ruta', 'mesa_ayuda_id'];
}
