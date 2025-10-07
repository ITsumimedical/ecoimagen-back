<?php

namespace App\Http\Modules\Permisos\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Permisos\Repositories\PermisoRepository;
use App\Http\Modules\Permisos\Requests\ActualizarPermisoRequest;
use App\Http\Modules\Permisos\Requests\CrearPermisoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Permission;

class PermisoController extends Controller
{
    private $permisoRepository;

    public function __construct(PermisoRepository $permisoRepository)
    {
        $this->permisoRepository = $permisoRepository;
    }

    public function listar(Request $request){
        try {
            $permisos = $this->permisoRepository->listarPermisos($request);
            return response()->json([
                'res' => true,
                'data' => $permisos
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'message' => 'Error al recuperar los permisos'
            ], 400);
        }
    }


    public function crear(CrearPermisoRequest $request): JsonResponse
    {
        try {
            $permiso = $this->permisoRepository->crear($request->all());
            return response()->json([
                'res'=> true,
                'data' => $permiso
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'message' => 'Error al crear permiso!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(ActualizarPermisoRequest $request, int $id): JsonResponse
    {
       try {
        $permiso = $this->permisoRepository->buscar($id);
        $permiso->fill($request->validated());
        $actualizarPermiso = $this->permisoRepository->guardar($permiso);
        return response()->json([
            'res' => true,
            'data' => $actualizarPermiso,
            'mensaje' => 'Permiso actualizado con exito!.'
        ], Response::HTTP_OK);
       } catch (\Throwable $th) {
        return response()->json([
            'res' => false,
            'mensaje' => 'Error al actualizar permiso!'
        ], Response::HTTP_BAD_REQUEST);
       }
    }

    /**
     * lista los permisos dado un rol
     * @param Request $request
     * @return Response
     */
    public function getPermisosPorRol(Request $request, $rol_id){
        try {
            $permisosPorRol = $this->permisoRepository->getPermisosPorRol($rol_id);
            return response()->json($permisosPorRol);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

}
