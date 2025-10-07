<?php

namespace App\Http\Modules\PreguntasTest\Model;

use App\Http\Modules\respuestasTest\Model\RespuestasTest;
use App\Http\Modules\TipoTest\Model\tipoTest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class preguntasTipoTest extends Model
{
    use HasFactory;

    protected $fillable = ['tipo_test_id', 'pregunta'];

    public function tipoTest()
    {
        return $this->belongsTo(tipoTest::class, 'tipo_test_id');
    }

}
