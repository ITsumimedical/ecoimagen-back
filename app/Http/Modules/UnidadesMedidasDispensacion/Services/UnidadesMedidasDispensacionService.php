<?php

namespace App\Http\Modules\UnidadesMedidasDispensacion\Services;

use App\Http\Modules\UnidadesMedidasDispensacion\Model\UnidadesMedidasDispensacion;

class UnidadesMedidasDispensacionService {


    public function actualizar($id,$data){
        return UnidadesMedidasDispensacion::findOrFail($id)->update($data);
    }
}
