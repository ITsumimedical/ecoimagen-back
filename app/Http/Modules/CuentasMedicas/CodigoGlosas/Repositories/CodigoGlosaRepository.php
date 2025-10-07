<?php

namespace App\Http\Modules\CuentasMedicas\CodigoGlosas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CuentasMedicas\CodigoGlosas\Models\CodigoGlosa;



class CodigoGlosaRepository extends RepositoryBase {

    protected $codigoGlosa;

    public function __construct() {
        $this->codigoGlosa = new CodigoGlosa();
        parent::__construct($this->codigoGlosa);
    }

    public function listarCodigoGlosas($data){

    $codigo = $this->codigoGlosa->whereListarCodigosGlosas();
    return  $codigo->get();

    }

    public function cambiarEstado($idCodigoGlosa){
        $codigo = $this->codigoGlosa::find($idCodigoGlosa);
        return $codigo->update([
            'estado' => false
          ]);
    }



}
