<?php

namespace App\Http\Modules\ParametrizacionRemisionProgramas\Services;

use App\Http\Modules\ParametrizacionRemisionProgramas\Model\ParametrizacionRemisionProgramas;
use App\Http\Modules\ParametrizacionRemisionProgramas\Repositories\ParametrizacionRemisionProgramasRepository;

class ParametrizacionRemisionProgramasService {

    public function actualizarPrograma($id, $data)
    {
        $programa = ParametrizacionRemisionProgramas::findOrFail($id);
        return $programa->update($data);
    }
}
