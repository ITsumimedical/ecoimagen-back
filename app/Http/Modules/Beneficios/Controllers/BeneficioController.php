<?php

namespace App\Http\Modules\Beneficios\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Beneficios\Models\Beneficio;
use App\Http\Modules\Beneficios\Repositories\BeneficiosRepository;
use App\Http\Modules\Beneficios\Requests\ActualizarBeneficioRequest;
use App\Http\Modules\Beneficios\Requests\CrearBeneficioRequest;

class BeneficioController extends Controller
{
    private $beneficioRepository;

    public function __construct(){
        $this->beneficioRepository = new BeneficiosRepository;
    }

    /**
     * lista los beneficios
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $beneficio = $this->beneficioRepository->listar($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $beneficio
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los beneficios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un beneficio
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearBeneficioRequest $request):JsonResponse{
        try {
            $beneficio = $this->beneficioRepository->crear($request->validated());
            return response()->json($beneficio, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un beneficio
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarBeneficioRequest $request, Beneficio $id){
        try {
            $this->beneficioRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }
}
