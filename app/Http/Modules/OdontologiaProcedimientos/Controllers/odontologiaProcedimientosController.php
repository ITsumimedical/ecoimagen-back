<?php

namespace App\Http\Modules\OdontologiaProcedimientos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\OdontologiaProcedimientos\Repositories\odontologiaProcedimientosRepository;
use App\Http\Modules\OdontologiaProcedimientos\Requests\CrearOdontologiaProcedimientosRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class odontologiaProcedimientosController extends Controller
{
    public function __construct(
        private odontologiaProcedimientosRepository $odontologiaProcedimientosRepository,
    ) {}

    public function agregarCupConsulta(CrearOdontologiaProcedimientosRequest $request)
    {
        try {
            $cups = $this->odontologiaProcedimientosRepository->crear($request->validated());
            return response()->json($cups, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function listarProcedimientos($consulta_id)
    {
        try {
            $procedimientos = $this->odontologiaProcedimientosRepository->listarProcedimientos($consulta_id);
            return response()->json($procedimientos);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function eliminar($id)
    {
        try {
            $this->odontologiaProcedimientosRepository->eliminarRegistro($id);
            return response()->json(['Mensaje' => 'Eliminado con éxito'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
}
