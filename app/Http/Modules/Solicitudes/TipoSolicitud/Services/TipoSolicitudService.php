<?php

namespace App\Http\Modules\Solicitudes\TipoSolicitud\Services;

use App\Http\Modules\Solicitudes\TipoSolicitud\Models\TipoSolicitudRedVital;
use App\Http\Modules\Solicitudes\TipoSolicitud\Repositories\TipoSolicitudRedVitalRepository;
use App\Http\Modules\Solicitudes\TipoSolicitudEmpleado\Repositories\TipoSolicitudEmpleadoRepository;

class TipoSolicitudService
{

    public function __construct(
        private TipoSolicitudRedVitalRepository $tipoSolicitudRedVitalRepository,
        private TipoSolicitudEmpleadoRepository $tipoSolicitudEmpleadoRepository
    ) {}

    public function actualizar($request)
    {
        if (!empty($request['empleados'])) {
            foreach ($request['empleados'] as $empleado) {
                $this->tipoSolicitudEmpleadoRepository->crearoActualizar($empleado, $request['id']);
            }
        }

        $this->tipoSolicitudRedVitalRepository->actualizarTipo($request);

        if (!empty($request['entidades'])) {
            $tipoSolicitud = TipoSolicitudRedVital::find($request['id']);

            if ($tipoSolicitud) {
                $tipoSolicitud->entidades()->sync($request['entidades']);
            }
        }
    }
}
