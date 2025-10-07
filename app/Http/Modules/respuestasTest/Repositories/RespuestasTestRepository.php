<?php

namespace App\Http\Modules\respuestasTest\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\respuestasTest\Model\RespuestasTest;
use Illuminate\Support\Facades\DB;

class RespuestasTestRepository extends RepositoryBase {

    public function __construct(protected RespuestasTest $respuestaTest)
    {
        parent::__construct($this->respuestaTest);
    }

    public function agregarRespuestas(array $respuestas)
    {
        DB::beginTransaction();
        try {
            $result = [];
            foreach ($respuestas as $respuestaData) {
                $result[] = $this->respuestaTest->create($respuestaData);
            }
            DB::commit();
            return $result;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
