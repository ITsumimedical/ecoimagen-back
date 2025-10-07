<?php

namespace App\Http\Modules\EvaluacionesPeriodosPruebas\PlantillasEvaluacionesPeriodosPruebas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\EvaluacionesPeriodosPruebas\PlantillasEvaluacionesPeriodosPruebas\Models\PlantillaEvaluacionPeriodoPrueba;
use App\Http\Modules\EvaluacionesPeriodosPruebas\PlantillasEvaluacionesPeriodosPruebas\Repositories\PlantillaEvaluacionPeriodoPruebaRepository;
use App\Http\Modules\EvaluacionesPeriodosPruebas\PlantillasEvaluacionesPeriodosPruebas\Requests\ActualizarPlantillaEvaluacionPeriodoPruebaRequest;
use App\Http\Modules\EvaluacionesPeriodosPruebas\PlantillasEvaluacionesPeriodosPruebas\Requests\CrearPlantillaEvaluacionPeriodoPruebaRequest;

class PlantillaEvaluacionPeriodoPruebaController extends Controller
{
    private $plantillaRepository;

    public function __construct(){
        $this->plantillaRepository = new PlantillaEvaluacionPeriodoPruebaRepository;
    }

    /**
     * lista plantillas para la evaluación de periodo de prueba
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $plantilla = $this->plantillaRepository->listar($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $plantilla
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar las plantillas de evaluación de periodo de prueba',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una plantilla de evaluación de periodo de prueba
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearPlantillaEvaluacionPeriodoPruebaRequest $request):JsonResponse{
        try {
            $plantilla = $this->plantillaRepository->crear($request->validated());
            return response()->json($plantilla, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una plantilla de evaluación de periodo de prueba
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarPlantillaEvaluacionPeriodoPruebaRequest $request, PlantillaEvaluacionPeriodoPrueba $id){
        try {
            $this->plantillaRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }

}
