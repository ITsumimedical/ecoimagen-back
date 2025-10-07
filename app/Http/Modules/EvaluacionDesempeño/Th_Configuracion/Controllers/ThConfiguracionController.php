<?php

namespace App\Http\Modules\EvaluacionDesempeño\Th_Configuracion\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\EvaluacionDesempeño\Th_Configuracion\Models\Configuracion;
use App\Http\Modules\EvaluacionDesempeño\Th_Configuracion\Requests\CreateThConfiguracionRequest;
use App\Http\Modules\EvaluacionDesempeño\Th_Configuracion\Repositories\ThConfiguracionRepository;

class ThConfiguracionController extends Controller
{
    protected $ThConfiguracionRepository;

    public function __construct(ThConfiguracionRepository $ThConfiguracionRepository) {
        $this->ThConfiguracionRepository = $ThConfiguracionRepository;
    }


    public function crear(CreateThConfiguracionRequest $request): JsonResponse
    {
        try {
            $newThConfiguracion = new Configuracion($request->validated());
            $ThConfiguracion = $this->ThConfiguracionRepository->crearConfiguracion($newThConfiguracion);
            return response()->json([
                $ThConfiguracion,
                'mensaje' => 'Fechas de evaluacion creada con exito!'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear fecha de evaluacion'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function fechaEvaluacion()
    {
        try {
            $fechaEvaluacion = $this->ThConfiguracionRepository->ultimaFechaEvaluacion();
            return response()->json($fechaEvaluacion, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar la fecha de la evaluacion'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
