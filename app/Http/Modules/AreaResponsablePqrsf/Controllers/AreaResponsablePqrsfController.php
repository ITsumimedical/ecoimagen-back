<?php

namespace App\Http\Modules\AreaResponsablePqrsf\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\AreaResponsablePqrsf\Repositories\AreaResponsablePqrsfRepository;
use App\Http\Modules\AreaResponsablePqrsf\Services\AreaResponsablePqrsfService;
use Illuminate\Http\JsonResponse;

class AreaResponsablePqrsfController extends Controller
{
    public function __construct(private AreaResponsablePqrsfRepository $responsablePqrsfRespository, private AreaResponsablePqrsfService $areaResponsablePqrsfService) {}

    public function listar(Request $request)
    {
        try {
            $responsable = $this->responsablePqrsfRespository->listarReponsable($request);
            return response()->json($responsable, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'Error al recuperar los responsables',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    public function listarTodo(Request $request)
    {
        try {
            $responsable = $this->responsablePqrsfRespository->listarTodo($request);
            return response()->json($responsable, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'Error al recuperar los responsables',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(Request $request)
    {
        // return $request->all();
        try {
            $responsable = $this->areaResponsablePqrsfService->guardar($request->all());
            return response()->json($responsable, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function CambiarEstado($id)
    {
        try {
            $cambiarEstado = $this->responsablePqrsfRespository->cambiarEstado($id);
            return response()->json($cambiarEstado, Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(Request $request, int $id)
    {


        try {
            $responsablePqr = $this->responsablePqrsfRespository->buscar($id);
            $responsablePqr->fill($request->except(["responsable", "responsable_id"]));
            $responsableUpdate = $this->responsablePqrsfRespository->guardar($responsablePqr);
            $responsablePqr->responsable()->sync($request->responsable_id);
            return response()->json([
                'res' => true,
                'mensaje' => 'Actualizado con exito!.'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Obtiene las Áreas del usuario autenticado
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarAreasUsuario() 
    {
        try {
            $areas = $this->responsablePqrsfRespository->listarAreasUsuario();
            return response()->json($areas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
