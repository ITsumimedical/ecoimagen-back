<?php

namespace App\Http\Modules\respuestasTest\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\PreguntasTest\Model\preguntasTipoTest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestasTest extends Model
{
    use HasFactory;

    protected $fillable = ['consulta_id', 'pregunta_id', 'respuesta'];

    public function Consulta()
    {
        return $this->belongsTo(Consulta::class, 'consulta_id');
    }

    public function pregunta()
    {
        return $this->belongsTo(preguntasTipoTest::class, 'pregunta_id');
    }
}
