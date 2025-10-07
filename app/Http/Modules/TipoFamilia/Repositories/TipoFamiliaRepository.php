<?php

namespace App\Http\Modules\TipoFamilia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoFamilia\Models\TipoFamilia;

class TipoFamiliaRepository extends RepositoryBase {

    protected $model;

    public function __construct(){
        $this->model = new TipoFamilia();
        parent::__construct($this->model);
    }

     /**
     * Cambia el estado
     * @param TipoFamilia
     * @return boolean
     * @author Arles Garcia
     */
    public function cambiarEstado($modelo){
        return $modelo->update([
            'activo' => !$modelo->activo
        ]);
    }

    public function eliminar($modelo){
        return $modelo->delete();
    }

}
