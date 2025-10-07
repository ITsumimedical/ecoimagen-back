<?php

namespace App\Http\Modules\ProcesoTutela\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ProcesoTutela\Models\ProcesoTutela;

class ProcesoTutelaRepository extends RepositoryBase
{
    protected $Model;

    public function __construct(){
        $this->Model = new ProcesoTutela();
        parent::__construct($this->Model);
    }

    /**
     * Lista los procesos que se crearon. Se listan sin paginación dado que son menos de 100 datos
     * @return $lista de datos creada
     * @author AlejoSR
     */
    public function listarProceso($data){
        $consulta = $this->listar($data)->select(['id','nombre','estado']);

        return $consulta;


    }

}
