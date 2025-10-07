<?php

namespace App\Http\Modules\GestionPqrsf\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncuestaSatisfaccionPqr extends Model
{
    use HasFactory;

    protected $table = 'encuesta_satisfaccion_pqr';

    protected $fillable = ['formulario_pqr_id','solucion_final','comprension_clara','respuesta_coherente'];

}
