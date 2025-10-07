<?php

namespace App\Http\Modules\interpretacionResultados\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class interpretacionResultados extends Model
{
    use HasFactory;

    protected $fillable = ['consulta_id', 'nombre_test', 'interpretacion_resultado_final'];
}
