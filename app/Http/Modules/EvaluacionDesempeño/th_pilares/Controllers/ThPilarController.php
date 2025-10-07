<?php

namespace App\Http\Modules\EvaluacionDesempeño\th_pilares\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\EvaluacionDesempeño\th_pilares\Models\ThPilar;
use App\Http\Modules\EvaluacionDesempeño\th_pilares\Repositories\ThPilarRepository;
use App\Http\Modules\EvaluacionDesempeño\th_pilares\Requests\ActualizarThPilarRequest;
use App\Http\Modules\EvaluacionDesempeño\th_pilares\Requests\CreateThPilarRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ThPilarController extends Controller
{
    protected $ThPilarRepository;

    public function __construct(ThPilarRepository $ThPilarRepository) {
        $this->ThPilarRepository = $ThPilarRepository;
    }

    /**
     * listar todos los pilares de evaluacion de desempeño
     *
     * @return JsonResponse
     * @throws Exception
     * @author Calvarez
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $listar = $this->ThPilarRepository->listar($request);
            return response()->json($listar, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * crar un pilar para la parametrizacion de evaluacion desempeño
     *
     * @param  mixed $request nombre, porcentaje, orden esta_activo, tipo_plantilla_id
     * @return Object
     *
     * @return JsonResponse
     * @throws Exception
     * @author Calvarez
     */
    public function crear(CreateThPilarRequest $request): JsonResponse
    {
        try {
            $nuevaThPilarRepository = new ThPilar($request->validated());
            $ThPilar = $this->ThPilarRepository->guardar($nuevaThPilarRepository);
            return response()->json([
                $ThPilar,
                'mensaje' => 'Pilar creado con exito!'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear el pilar!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualizar un pilar.
     *
     * @param  mixed $request nombre, porcentaje, orden esta_activo, tipo_plantilla_id
     * @param  int $id id del pilar.
     *
     * @return JsonResponse
     * @throws Exception
     * @author Calvarez
     */
    public function actualizar(ActualizarThPilarRequest $request, int $id)
    {
        try {
            $ThPilar = $this->ThPilarRepository->buscar($id);
            $this->ThPilarRepository->actualizar($ThPilar, $request->validated());
            return response()->json([
                $ThPilar,
                'mensaje' => 'Pilar actualizado con exito!'
            ], Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje'   => 'Error al actualizar el pilar!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
