<?php

namespace App\Http\Modules\Estadistica\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Estadistica\Services\EstadisticaService;
use App\Http\Modules\Estadistica\Requests\CrearEstadisticaRequest;
use App\Http\Modules\Estadistica\Repositories\EstadisticaRepository;
use App\Http\Modules\Estadistica\Requests\ActualizarEstadisticaRequest;

class EstadisticaController extends Controller
{

    public function __construct(
        private EstadisticaRepository $estadisticaRepository,
        private EstadisticaService $estadisticaService
    ) {
    }

    public function listar($UserId)
    {
        try {
            $estadistica = $this->estadisticaRepository->listarEstadistica($UserId);
            return response()->json($estadistica, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(CrearEstadisticaRequest $request)
    {
        try {
            $this->estadisticaService->crearEstadistica($request);
            return response()->json([
                'mensaje' => 'Estadística creada con éxito'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function actualizar(ActualizarEstadisticaRequest $request, $id)
    {
        try {
            $this->estadisticaRepository->actualizarEstadistica($id, $request->validated());
            return response()->json([
                'mensaje' => 'Se ha actualizado la estadistica correctamente.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function eliminar($id)
    {
        try {
            $this->estadisticaRepository->eliminarEstadistica($id);
            return response()->json([
                'mensaje' => 'Se ha eliminado la estadistica correctamente.',
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
