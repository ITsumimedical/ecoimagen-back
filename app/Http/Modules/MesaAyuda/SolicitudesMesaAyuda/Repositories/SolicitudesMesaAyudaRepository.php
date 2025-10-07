<?php

namespace App\http\Modules\MesaAyuda\SolicitudesMesaAyuda\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\MesaAyuda\SolicitudesMesaAyuda\Models\SolicitudMesaAyuda;

class SolicitudesMesaAyudaRepository extends RepositoryBase {

    protected $solicitudMesaAyudaModel;

    public function __construct(SolicitudMesaAyuda $solicitudMesaAyudaModel){
        parent::__construct($solicitudMesaAyudaModel);
        $this->solicitudMesaAyudaModel = $solicitudMesaAyudaModel;
    }

    public function listarSolicitudes()
    {
        return SolicitudMesaAyuda::select('categoria_mesa_ayuda_empleados.id', 'categoria_mesa_ayuda_empleados.activo', 'categoria_mesa_ayudas.nombre as nombreCategoria')
                                ->selectRaw("CONCAT(empleados.primer_nombre,' ',empleados.primer_apellido,' ',empleados.segundo_nombre,' ',empleados.segundo_apellido) as nombreCompleto")
                                ->join('categoria_mesa_ayudas', 'categoria_mesa_ayuda_empleados.categoria_mesa_ayuda_id', 'categoria_mesa_ayudas.id')
                                ->join('empleados', 'categoria_mesa_ayuda_empleados.empleado_id', 'empleados.id')
                                ->get();
    }
}
