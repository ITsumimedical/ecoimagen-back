<?php

namespace App\Http\Modules\FormaFarmaceuticaffm\Services;

use App\Http\Modules\FormaFarmaceuticaffm\Model\FormaFarmaceuticaffm;

class FormaFarmaceuticaffmService {


    public function actualizarFormasFarmaceuticasffm($id,$data){
        return FormaFarmaceuticaffm::findOrFail($id)->update($data);
    }

    public function cambiarEstado($id) {
        $forma = FormaFarmaceuticaffm::findOrFail($id);
        $forma->update(['habilitado' => !$forma->habilitado ]);
        return true;
    }
}
