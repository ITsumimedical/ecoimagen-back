<?php

namespace App\Http\Modules\AreasTalentoHumano\Repositories;

use App\Http\Modules\AreasTalentoHumano\Models\AreaTh;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Empleados\Models\Empleado;

class AreaThRepository extends RepositoryBase
{
    protected $empleadoModel;

    public function __construct(){
       $empleadoModel = new AreaTh();
       parent::__construct($empleadoModel);
       $this->empleadoModel = $empleadoModel;
    }

    public function areaCategoria($areaTh_id)
    {
        $area = AreaTh::find($areaTh_id);

        return $area->categorias;
    }

    public function empleadosArea($areaTh_id)
    {
        $empleadosDelArea = Empleado::select()
                            ->join('area_ths', 'empleados.areath_id', 'area_ths.id')
                            ->where('area_ths.id', $areaTh_id)
                            ->get();
        return $empleadosDelArea;
    }


}
