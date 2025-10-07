<?php

namespace App\Http\Modules\Roles\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Modules\Roles\Repositories\RolRepository;
use App\Http\Modules\Roles\Requests\ActualizarRolRequest;
use App\Http\Modules\Roles\Requests\CrearRolRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RolController extends Controller
{
    private $rolRepository;

    public function __construct(RolRepository $rolRepository)
    {
        $this->rolRepository = $rolRepository;
    }

    public function listar(Request $request)
    {
        try {
            $roles = $this->rolRepository->listar($request);
            return response()->json($roles, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar roles'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(CrearRolRequest $request):JsonResponse
    {
        try {
            $nuevoRol =  new Role($request->validated());
            $role = $this->rolRepository->guardar($nuevoRol);
            return response()->json([
                'res' => true,
                'data' => $role,
                'mensaje' => 'Rol creado con exito!.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear rol'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(ActualizarRolRequest $request, int $id): JsonResponse
    {
        try {
            $role = $this->rolRepository->buscar($id);
            $role->fill($request->validated());

            $actualizarRol = $this->rolRepository->guardar($role);

            return response()->json([
                'res' => true,
                'data' => $actualizarRol,
                'mensaje' => 'Rol actualizado con exito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar rol'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function agregarPermiso(Request $request, Role $id)
    {
        try {
            $agregarPermisoRol = $id->givePermissionTo($request->permissions);
            return response()->json([
                'res' => true,
                'data' => $agregarPermisoRol,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'message' => 'Error al agregar permiso al rol!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function removerPermiso(Request $request, Role $id)
    {
        try {
            $removerPermisoRol = $id->revokePermissionTo($request->permission);
            return response()->json([
                'res' => true,
                'data' => $removerPermisoRol,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'message' => 'Error al remover el permiso del rol!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
