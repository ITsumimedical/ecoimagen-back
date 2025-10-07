<?php

namespace App\Http\Modules\Prioridades\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Prioridades\Models\Prioridad;
use App\Http\Modules\Prioridades\Repositories\PrioridadRepository;
use App\Http\Modules\Prioridades\Requests\ActualizarPrioridadRequest;
use App\Http\Modules\Prioridades\Requests\CrearPrioridadRequest;
use phpseclib3\Crypt\EC\Curves\prime256v1;

class PrioridadControllers extends Controller
{
    protected $prioridadeRepository;

    public function __construct(PrioridadRepository $prioridadeRepository) {
        $this->prioridadeRepository = $prioridadeRepository;
    }

    /**
     * listar todas prioridades
     *
     * @return JsonResponse
     * @throws Exception
     * @author Calvarez
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $listar = $this->prioridadeRepository->listarPrioridad($request);
            return response()->json($listar, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * crar una prioridad
     *
     * @param  mixed $request nombre,descripcion,tiempo,estado_id
     * @return Object
     *
     * @return JsonResponse
     * @throws Exception
     * @author Calvarez
     */
    public function crear(CrearPrioridadRequest $request): JsonResponse
    {
        try {
            $nuevaPrioridad = new Prioridad($request->validated());
            $prioridad = $this->prioridadeRepository->guardar($nuevaPrioridad);
            return response()->json([
                $prioridad,
                'mensaje' => 'Prioridad creada con exito!'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al crear la prioridad!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualizar una prioridad.
     *
     * @param  mixed $request nombre,descripcion,tiempo,estado_id
     * @param  int $id id de la prioridad.
     *
     * @return JsonResponse
     * @throws Exception
     * @author Calvarez
     */
    public function actualizar(ActualizarPrioridadRequest $request, int $id)
    {
        try {
            $prioridad = $this->prioridadeRepository->buscar($id);
            $this->prioridadeRepository->actualizar($prioridad, $request->validated());
            return response()->json([
                $prioridad,
                'mensaje' => 'Prioridad actualizada con exito!'
            ], Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje'   => 'Error al actualizar la prioridad!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
