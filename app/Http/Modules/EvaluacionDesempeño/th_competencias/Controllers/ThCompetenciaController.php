<?php

namespace App\Http\Modules\EvaluacionDesempeño\th_competencias\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\EvaluacionDesempeño\th_competencias\Models\ThCompetencia;
use App\Http\Modules\EvaluacionDesempeño\th_competencias\Repositories\ThCompetenciaRepository;
use App\Http\Modules\EvaluacionDesempeño\th_competencias\Requests\ActualizarThCompetenciaRequest;
use App\Http\Modules\EvaluacionDesempeño\th_competencias\Requests\CreateThCompetenciaRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ThCompetenciaController extends Controller
{
    protected $ThCompetenciaRepository;

    public function __construct(ThCompetenciaRepository $ThCompetenciaRepository) {
        $this->ThCompetenciaRepository = $ThCompetenciaRepository;
    }

    /**
     * listar todos las competencias de evaluacion de desempeño
     *
     * @return JsonResponse
     * @throws Exception
     * @author Calvarez
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $listar = $this->ThCompetenciaRepository->listar($request);
            return response()->json($listar, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * crar una competencia para la parametrizacion de evaluacion desempeño
     *
     * @param  mixed $request competencia, descripcion, th_pilar_id
     * @return Object
     *
     * @return JsonResponse
     * @throws Exception
     * @author Calvarez
     */
    public function crear(CreateThCompetenciaRequest $request): JsonResponse
    {
        try {
            $nuevaThCompetencia = new ThCompetencia($request->validated());
            $ThCompetencia = $this->ThCompetenciaRepository->guardar($nuevaThCompetencia);
            return response()->json([
                $ThCompetencia,
                'mensaje' => 'Competencia creada con exito!'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear la competencia!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualizar una competencia.
     *
     * @param  mixed $request competencia, descripcion, th_pilar_id
     * @param  int $id id de la competencia.
     *
     * @return JsonResponse
     * @throws Exception
     * @author Calvarez
     */
    public function actualizar(ActualizarThCompetenciaRequest $request, int $id)
    {
        try {
            $ThCompetencia = $this->ThCompetenciaRepository->buscar($id);
            $this->ThCompetenciaRepository->actualizar($ThCompetencia, $request->validated());
            return response()->json([
                $ThCompetencia,
                'mensaje' => 'Competencia actualizada con exito!'
            ], Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje'   => 'Error al actualizar la competencia!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
