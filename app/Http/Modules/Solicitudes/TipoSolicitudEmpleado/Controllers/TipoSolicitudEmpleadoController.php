<?php

namespace App\Http\Modules\Solicitudes\TipoSolicitudEmpleado\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Solicitudes\TipoSolicitudEmpleado\Repositories\TipoSolicitudEmpleadoRepository;
use App\Http\Modules\Solicitudes\TipoSolicitudEmpleado\Requests\InactivarRequest;
use App\Http\Modules\Solicitudes\TipoSolicitudEmpleado\Requests\ListarTipoSolicitudEmpleadoRequest;

class TipoSolicitudEmpleadoController extends Controller
{
    public function __construct(private TipoSolicitudEmpleadoRepository $tipoSolicitudEmpleadoRepository) {
    }

    public function listar(ListarTipoSolicitudEmpleadoRequest $request){
        try {
            $tipoSolicitud = $this->tipoSolicitudEmpleadoRepository->listarTipo($request->validated());
            return response()->json($tipoSolicitud, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function inactivar(InactivarRequest $request){
        try {
             $this->tipoSolicitudEmpleadoRepository->inactivarEmpleado($request->validated());
            return response()->json('Inactivado con exito!', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
