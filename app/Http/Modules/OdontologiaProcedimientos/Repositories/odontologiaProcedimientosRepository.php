<?php

namespace App\Http\Modules\OdontologiaProcedimientos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\OdontologiaProcedimientos\Model\odontologiaProcedimientos;

class odontologiaProcedimientosRepository extends RepositoryBase {

    public function __construct(protected odontologiaProcedimientos $odontologiaProcedimientos)
    {
        parent::__construct($this->odontologiaProcedimientos);
    }


    public function listarProcedimientos($consulta_id)
    {
        return $this->odontologiaProcedimientos::with('cup:id,codigo,nombre')
        ->where('consulta_id', $consulta_id)
        ->orderBy('id', 'desc')
        ->get();
    }

    public function eliminarRegistro($id)
    {
        $this->odontologiaProcedimientos::where('id', $id)->delete();

    }
}
