<?php

namespace App\Http\Modules\EvaluacionesPeriodosPruebas\EvaluacionesPeriodosPruebas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\EvaluacionesPeriodosPruebas\EvaluacionesPeriodosPruebas\Models\EvaluacionPeriodoPrueba;
use App\Http\Modules\EvaluacionesPeriodosPruebas\EvaluacionesPeriodosPruebas\Repositories\EvaluacionPeriodoPruebaRepository;
use App\Http\Modules\EvaluacionesPeriodosPruebas\EvaluacionesPeriodosPruebas\Requests\ActualizarEvaluacionPeriodoPruebaRequest;
use App\Http\Modules\EvaluacionesPeriodosPruebas\EvaluacionesPeriodosPruebas\Requests\CrearEvaluacionPeriodoPruebaRequest;

class EvaluacionPeriodoPruebaController extends Controller
{
    private $evaluacionPeriodoPruebaRepository;

    public function __construct(){
        $this->evaluacionPeriodoPruebaRepository = new EvaluacionPeriodoPruebaRepository;
    }

    /**
     * lista las evaluaciones de prueba
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $evaluacion = $this->evaluacionPeriodoPruebaRepository->listarEvaluaciones($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $evaluacion
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar las evaluaciones periodos prueba',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una evaluación de periodo de prueba
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearEvaluacionPeriodoPruebaRequest $request):JsonResponse{
        try {
            $evaluacion = $this->evaluacionPeriodoPruebaRepository->crear($request->validated());
            return response()->json($evaluacion, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una evaluación de periodo de prueba
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarEvaluacionPeriodoPruebaRequest $request, EvaluacionPeriodoPrueba $id){
        try {
            $this->evaluacionPeriodoPruebaRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }


}
