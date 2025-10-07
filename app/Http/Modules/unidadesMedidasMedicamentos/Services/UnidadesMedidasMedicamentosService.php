<?php

namespace App\Http\Modules\unidadesMedidasMedicamentos\Services;

use App\Http\Modules\unidadesMedidasMedicamentos\Model\UnidadesMedidasMedicamentos;

class UnidadesMedidasMedicamentosService {


    public function actualizar($id,$data){
        return UnidadesMedidasMedicamentos::findOrFail($id)->update($data);
    }

}
