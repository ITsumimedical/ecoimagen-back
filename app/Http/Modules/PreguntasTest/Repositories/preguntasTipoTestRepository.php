<?php

namespace App\Http\Modules\PreguntasTest\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\PreguntasTest\Model\preguntasTipoTest;

class preguntasTipoTestRepository extends RepositoryBase
{

    public function __construct(protected preguntasTipoTest $preguntasTipoTest)
    {
        parent::__construct($this->preguntasTipoTest);
    }


    public function listarPreguntas()
    {
        $preguntasTipoTest = $this->preguntasTipoTest->select('preguntas_tipo_tests.id', 'preguntas_tipo_tests.tipo_test_id', 'preguntas_tipo_tests.pregunta', 'tipo_tests.nombre as tipo_test')
        ->join('tipo_tests', 'preguntas_tipo_tests.tipo_test_id', 'tipo_tests.id')
        ->get();
        return $preguntasTipoTest;
    }

    public function listarPreguntasPorNombreTest($nombreTest)
    {
        return $this->preguntasTipoTest
            ->join('tipo_tests', 'preguntas_tipo_tests.tipo_test_id', 'tipo_tests.id')
            ->where('tipo_tests.nombre', $nombreTest)
            ->select('preguntas_tipo_tests.id', 'preguntas_tipo_tests.pregunta')
            ->get();
    }
}
