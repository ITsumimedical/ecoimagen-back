<?php

namespace App\Http\Modules\SeguimientoCompromisos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\SeguimientoCompromisos\Models\SeguimientoCompromiso;

class SeguimientoCompromisoRepository extends RepositoryBase
{
    protected $model;

    public function __construct() {
        $this->model = new SeguimientoCompromiso();
        parent::__construct($this->model);
    }

    public function listarSeguimiento(int $id)
    {
        $seguimientos = SeguimientoCompromiso::where('calificacion_competencia_id',$id)->with('usuario.operador')->get();
        return $seguimientos;
    }

}
