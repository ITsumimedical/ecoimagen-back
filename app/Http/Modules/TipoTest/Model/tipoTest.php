<?php

namespace App\Http\Modules\TipoTest\Model;

use App\Http\Modules\PreguntasTest\Model\preguntasTipoTest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipoTest extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function preguntas()
    {
        return $this->hasMany(preguntasTipoTest::class, 'tipo_test_id');
    }
}
