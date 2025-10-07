<?php

namespace App\Http\Modules\Evoluciones\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Evoluciones\Models\Evolucion;
use App\Http\Modules\Evoluciones\Repositories\EvolucionRepository;
use App\Http\Modules\Evoluciones\Requests\ActualizarEvolucionRequest;
use App\Http\Modules\Evoluciones\Requests\CrearEvolucionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EvolucionController extends Controller
{
    public function __construct(protected EvolucionRepository $evolucionRepository)
    {
    }


    /**
     * Creo una evolucion de urgencias
     * @param Request $request
     * @return Response $evolucion
     * @author JDSS
     */

    public function crear(CrearEvolucionRequest $request)
    {
        try {
            $evolucion = $this->evolucionRepository->crear($request->validated());
            return response()->json($evolucion);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Lista las evoluciones de una admisión de urgencias
     * @param int $admisionUrgenciasId
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarEvolucionesAdmision(int $admisionUrgenciasId): JsonResponse
    {
        try {
            $response = $this->evolucionRepository->listarEvolucionesAdmision($admisionUrgenciasId);
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Actualiza una evolucion existente
     * @param Evolucion $evolucionId
     * @param ActualizarEvolucionRequest $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function actualizarEvolucion(Evolucion $evolucionId, ActualizarEvolucionRequest $request): JsonResponse
    {
        try {
            $response = $this->evolucionRepository->actualizar($evolucionId, $request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
