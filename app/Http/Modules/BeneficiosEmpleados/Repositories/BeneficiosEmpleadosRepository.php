<?php

namespace App\Http\Modules\BeneficiosEmpleados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\BeneficiosEmpleados\Models\BeneficioEmpleado;

class BeneficiosEmpleadosRepository extends RepositoryBase {

    protected $beneficioEmpleadoModel;

    public function __construct() {
        $this->beneficioEmpleadoModel = new BeneficioEmpleado();
        parent::__construct($this->beneficioEmpleadoModel);
    }

    public function listart(){
        $listarBeneficiosEmpleados = BeneficioEmpleado::with('empleado:id,documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,fecha_nacimiento,edad,celular,email_personal,email_corporativo', 'beneficio:id,nombre,horas')
        ->get();

        return $listarBeneficiosEmpleados;
    }
}
