<?php

namespace App\Http\Modules\EvaluacionDesempeño\th_tipo_plantillas\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\EvaluacionDesempeño\th_tipo_plantillas\Models\ThTipoPlantilla;
use App\Http\Modules\EvaluacionDesempeño\th_tipo_plantillas\Repositories\ThTipoPlantillaRepository;
use App\Http\Modules\EvaluacionDesempeño\th_tipo_plantillas\Requests\ActualizarThTipoPlantillaRequest;
use App\Http\Modules\EvaluacionDesempeño\th_tipo_plantillas\Requests\CreateThTipoPlantillaRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ThTipoPlantillaController extends Controller
{
    protected $ThTipoPlantillaRepository;

    public function __construct(ThTipoPlantillaRepository $ThTipoPlantillaRepository) {
        $this->ThTipoPlantillaRepository = $ThTipoPlantillaRepository;
    }

    /**
     * listar todas plantillas de th
     *
     * @return JsonResponse
     * @throws Exception
     * @author Calvarez
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $listar = $this->ThTipoPlantillaRepository->listar($request);
            return response()->json($listar, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * crar una plantilla para la parametrizacion de evaluacion desempeño
     *
     * @param  mixed $request nombre, esta_activo
     * @return Object
     *
     * @return JsonResponse
     * @throws Exception
     * @author Calvarez
     */
    public function crear(CreateThTipoPlantillaRequest $request): JsonResponse
    {
        try {
            $nuevaThTipoPlantilla = new ThTipoPlantilla($request->validated());
            $ThTipoPlantilla = $this->ThTipoPlantillaRepository->guardar($nuevaThTipoPlantilla);
            return response()->json([
                $ThTipoPlantilla,
                'mensaje' => 'Tipo plantilla creada con exito!'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear el Tipo plantilla!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualizar una plantilla .
     *
     * @param  mixed $request nombre,esta_activo
     * @param  int $id id de la plantilla.
     *
     * @return JsonResponse
     * @throws Exception
     * @author Calvarez
     */
    public function actualizar(ActualizarThTipoPlantillaRequest $request, int $id)
    {
        try {
            $ThTipoPlantilla = $this->ThTipoPlantillaRepository->buscar($id);
            $this->ThTipoPlantillaRepository->actualizar($ThTipoPlantilla, $request->validated());
            return response()->json([
                $ThTipoPlantilla,
                'mensaje' => 'Plantilla actualizada con exito!'
            ], Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje'   => 'Error al actualizar la plantilla!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
