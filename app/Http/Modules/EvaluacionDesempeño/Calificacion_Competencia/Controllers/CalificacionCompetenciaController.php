<?php

namespace App\Http\Modules\EvaluacionDesempeño\Calificacion_Competencia\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\EvaluacionDesempeño\Calificacion_Competencia\Models\CalificacionCompetencia;
use App\Http\Modules\EvaluacionDesempeño\Calificacion_Competencia\Repositories\CalificacionCompetenciaRepository;
use App\Http\Modules\EvaluacionDesempeño\Calificacion_Competencia\Requests\CreateCalificacionCompetenciaRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CalificacionCompetenciaController extends Controller
{
    protected $CalificacionCompetenciarepository;

    public function __construct(CalificacionCompetenciaRepository $CalificacionCompetenciarepository) {
        $this->CalificacionCompetenciarepository = $CalificacionCompetenciarepository;
    }

    /**
     * calificar una competencia
     *
     * @param  mixed $request evaluacion_desempeno_id, calificacion, th_competencia_id
     * @return Object
     *
     * @return JsonResponse
     * @throws Exception
     * @author Calvarez
     *
     */
    public function crear(CreateCalificacionCompetenciaRequest $request): JsonResponse
    {
        try {
            $nuevaCalificacionCompetencia = new CalificacionCompetencia($request->validated());
            $calificacionCompetencia = $this->CalificacionCompetenciarepository->firstOrCreateCalificacionDesempeno($nuevaCalificacionCompetencia);
            return response()->json($calificacionCompetencia, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear la competencia!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function calificacion(Request $request)
    {
        try {
            $calificacion = $this->CalificacionCompetenciarepository->consultarCalificaciones($request);
            return response()->json($calificacion, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear la competencia!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
