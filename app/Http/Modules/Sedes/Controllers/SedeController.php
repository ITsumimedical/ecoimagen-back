<?php

namespace App\Http\Modules\Sedes\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Sedes\Models\Sede;
use App\Http\Modules\Sedes\Requests\CrearSedeRequest;
use App\Http\Modules\Sedes\Repositories\SedeRepository;
use App\Http\Modules\Sedes\Requests\ActualizarSedeRequest;

class SedeController extends Controller
{
    private $sedeRepository;

    public function __construct(){
        $this->sedeRepository = new SedeRepository;
    }

    /**
     * lista las sedes
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request)
    {
        try {
            $sede = $this->sedeRepository->listar($request);
            return response()->json([
                'res' => true,
                'data' => $sede
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar las sedes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una sede
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearSedeRequest $request):JsonResponse{
        try {
            $sede = $this->sedeRepository->crear($request->validated());
            return response()->json($sede, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), Response::HTTP_BAD_REQUEST]);
        }
    }


    /**
     * Actualiza una sede
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarSedeRequest $request, int $id): JsonResponse
    {
        try {
            $sede = $this->sedeRepository->buscar($id);
            $sede->fill($request->all());

            $actualizaSede = $this->sedeRepository->guardar($sede);

            return response()->json([
                'res' => true,
                'data' => $actualizaSede,
                'mensaje' => 'Sede actualizada con exito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar la sede'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
