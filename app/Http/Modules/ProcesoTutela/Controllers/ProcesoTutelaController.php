<?php

namespace App\Http\Modules\ProcesoTutela\Controllers;

use Dedoc\Scramble\Support\OperationExtensions\RequestBodyExtension;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\ProcesoTutela\Models\ProcesoTutela;
use App\Http\Modules\ProcesoTutela\Repositories\ProcesoTutelaRepository;
use App\Http\Modules\ProcesoTutela\Requests\ActualizarProcesoTutelaRequest;
use App\Http\Modules\ProcesoTutela\Requests\CrearProcesoTutelaRequest;
use App\Http\Modules\ProcesoTutela\Services\ProcesoTutelaService;

class ProcesoTutelaController extends Controller
{
    protected $repository;

    public function __construct( private ProcesoTutelaService $procesoTutelaService){
        $this->repository = new ProcesoTutelaRepository();
    }

    /**
     * Listar todos los procesos creado por parte del usuario administrador
     * @return JsonResponse|mixed
     */
    public function listar(Request $request):JsonResponse
    {
        try {
            $proceso = $this->procesoTutelaService->listarProceso($request);
            return response()->json( [
                'res' => true,
                'data' => $proceso
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error los procesos de tutelas',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(CrearProcesoTutelaRequest $request): JsonResponse
    {
        try {
            $proceso = new ProcesoTutela($request->all());
            $nuevaProceso = $this->repository->guardar($proceso);
            return response()->json([
                'res' => true,
                'data' => $nuevaProceso,
                'mensaje' => 'Se ha creado el proceso con exito!',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear !',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(CrearProcesoTutelaRequest $request, int $id): JsonResponse
    {
        try {
            $area = $this->repository->buscar($id);
            $area->fill($request->all());
            $actualizarArea = $this->repository->guardar($area);
            return response()->json([
                'res' => true,
                'data' => $actualizarArea,
                'mensaje' => 'El proceso fue actualizado con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al intentar actualizar el proceso!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarEstado(ActualizarProcesoTutelaRequest $request, int $id): JsonResponse
    {
        try {
            $area = $this->repository->buscar($id);
            $area->fill($request->all());
            $actualizarArea = $this->repository->guardar($area);
            return response()->json([
                'res' => true,
                'data' => $actualizarArea,
                'mensaje' => 'El proceso fue actualizada con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al intentar actualizar el proceso!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
