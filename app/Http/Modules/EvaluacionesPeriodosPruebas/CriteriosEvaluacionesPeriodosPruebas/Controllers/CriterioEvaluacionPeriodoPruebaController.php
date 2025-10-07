<?php

namespace App\Http\Modules\EvaluacionesPeriodosPruebas\CriteriosEvaluacionesPeriodosPruebas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\EvaluacionesPeriodosPruebas\CriteriosEvaluacionesPeriodosPruebas\Models\CriterioEvaluacionPeriodoPrueba;
use App\Http\Modules\EvaluacionesPeriodosPruebas\CriteriosEvaluacionesPeriodosPruebas\Repositories\CriterioEvaluacionPeriodoPruebaRepository;
use App\Http\Modules\EvaluacionesPeriodosPruebas\CriteriosEvaluacionesPeriodosPruebas\Requests\ActualizarCriterioEvaluacionPeriodoPruebaRequest;
use App\Http\Modules\EvaluacionesPeriodosPruebas\CriteriosEvaluacionesPeriodosPruebas\Requests\CrearCriterioEvaluacionPeriodoPruebaRequest;

class CriterioEvaluacionPeriodoPruebaController extends Controller
{
    private $criterioRepository;

    public function __construct(){
        $this->criterioRepository = new CriterioEvaluacionPeriodoPruebaRepository;
    }

    /**
     * lista criterios para la evaluación de periodo de prueba
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $criterio = $this->criterioRepository->listarConPlantilla($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $criterio
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los criterios de evaluación de periodo de prueba',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un criterio de evaluación de periodo de prueba
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearCriterioEvaluacionPeriodoPruebaRequest $request):JsonResponse{
        try {
            $criterio = $this->criterioRepository->crear($request->validated());
            return response()->json($criterio, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un criterio de evaluación de periodo de prueba
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarCriterioEvaluacionPeriodoPruebaRequest $request, CriterioEvaluacionPeriodoPrueba $id){
        try {
            $this->criterioRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }
}
