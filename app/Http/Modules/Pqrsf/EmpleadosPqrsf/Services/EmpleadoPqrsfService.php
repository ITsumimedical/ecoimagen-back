<?php

namespace App\Http\Modules\Pqrsf\EmpleadosPqrsf\Services;

use App\Http\Modules\Pqrsf\EmpleadosPqrsf\Repositories\EmpleadosPqrsfRepository;
use App\Http\Modules\Pqrsf\IpsPqrsf\Repositories\IpsPqrsfRepository;

class EmpleadoPqrsfService
{

    public function __construct(private EmpleadosPqrsfRepository $empleadosPqrsfRepository) {

    }

    public function crearEmpleado($data){

        foreach ($data['operador_id'] as $empleado) {

         $this->empleadosPqrsfRepository->crearEmpleado($empleado,$data['pqrsf_id']);
        }

        return 'ok';
    }
}
