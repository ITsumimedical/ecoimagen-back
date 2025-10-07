<?php

namespace App\Http\Modules\Solicitudes\TipoSolicitudEntidad\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Solicitudes\TipoSolicitudEntidad\Requests\listarTipoSolicitudEntidadRequest;
use App\Http\Modules\Solicitudes\TipoSolicitudEntidad\Repositories\TipoSolicitudEntidadRepository;

class TipoSolicitudEntidadController extends Controller
{
    public function __construct(private TipoSolicitudEntidadRepository $tipoSolicitudEmpleadoRepository) {
    }

    public function listar(listarTipoSolicitudEntidadRequest $request){
        try {
            $tipoSolicitud = $this->tipoSolicitudEmpleadoRepository->listarTipo($request->validated());
            return response()->json($tipoSolicitud, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
