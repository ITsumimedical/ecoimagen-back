<?php

namespace App\Http\Modules\CuestionarioGad2\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cuestionarioGAD_2 extends Model
{
    use HasFactory;

    protected $fillable = [
    'sentirse_nervioso_ansioso',
    'no_poder_controlar_preocupacion',
    'interpretacion_resultado',
    'consulta_id',
    'afiliado_id',
    'resultado',
    ];


    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
