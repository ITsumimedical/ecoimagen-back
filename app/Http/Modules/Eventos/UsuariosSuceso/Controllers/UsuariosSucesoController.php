<?php

namespace App\Http\Modules\Eventos\UsuariosSuceso\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Eventos\UsuariosSuceso\Repositories\UsuariosSucesoRepository;
use App\Http\Modules\Eventos\UsuariosSuceso\Requests\CrearUsuarioDefectoRequest;
use App\Http\Modules\Eventos\UsuariosSuceso\Requests\CrearUsuarioSucesoRequest;
use App\Http\Modules\Eventos\UsuariosSuceso\Services\UsuarioSucesoService;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class UsuariosSucesoController extends Controller
{
    function __construct(
        private UsuariosSucesoRepository $usuariosSucesoRepository,
        private UsuarioSucesoService $usuarioSucesoService
    ) {}

    /**
     * Asigna un usuario por defecto para asociar a los sucesos
     * @param CrearUsuarioSucesoRequest $request
     * @return JsonResponse
     * @author AlejoSR
     */
    public function asignarUsuarioSuceso(CrearUsuarioSucesoRequest $request): JsonResponse
    {
        try {

            $crear = $this->usuarioSucesoService->asignarUsuarioSuceso($request->validated());
            return response()->json([
                'res' => true,
                'mensaje' => 'Usuario asociado por defecto correctamente',
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al asociar el usuario',
                'error' => $th->getMessage()
            ], 400);
        }
    }
    /**
     * Lista los usuarios que se asociaron por defecto a los sucesos
     * @return JsonResponse
     * @author AlejoSR
     */
    public function listarUsuarioSuceso(): JsonResponse
    {
        try {

            $usuariosSuceso = $this->usuarioSucesoService->listarUsuarioSuceso();
            return response()->json([
                'res' => true,
                'data' => $usuariosSuceso
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar los usuarios',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Elimina un usuario asociado por defecto
     * @param int $user_id
     * @return JsonResponse
     * @author AlejoSR
     */
    public function eliminarUsuariosuceso(Request $request, int $suceso_id, int $usuario_id): JsonResponse
    {
        try {
            $this->usuarioSucesoService->eliminarUsuarioSuceso($suceso_id, $usuario_id);
            return response()->json([
                'res' => true,
                'mensaje' => 'Usuario eliminado correctamente',
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al eliminar el usuario',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Elimina todos los usuarios asociados al suceso dado
     * @param Request $request
     * @param int $suceso_id
     * @return JsonResponse|mixed
     */
    public function eliminarSuceso(Request $request, int $suceso_id): JsonResponse
    {
        try {
            
            $this->usuariosSucesoRepository->eliminarSuceso($suceso_id);
            return response()->json([
                'res' => true,
                'mensaje' => 'Suceso eliminado correctamente',
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al eliminar el suceso',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Asigna un usuario por defecto para asociar a los sucesos
     * @param CrearUsuarioDefectoRequest $request
     * @return JsonResponse
     * @author AlejoSR
     */
    public function asignarUsuarioDefecto(CrearUsuarioDefectoRequest $request)
    {
        try {
            $crear = $this->usuarioSucesoService->asignarUsuarioDefecto($request->validated());
            return response()->json([
                'res' => true,
                'mensaje' => 'Usuario asociado por defecto correctamente',
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al asociar el usuario por defecto',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Elimina un usuario asociado por defecto
     * @param int $id_usuario
     * @return JsonResponse
     * @author AlejoSR
     */
    public function eliminarUsuarioDefecto(Request $request, int $id_usuario): JsonResponse{
        try{
            $this->usuarioSucesoService->eliminarUsuarioDefecto($id_usuario);
            return response()->json([
                'res' => true,
                'mensaje' => 'Usuario eliminado correctamente',
            ], 200);
        }catch (Throwable $th){
            return response()->json([
                'mensaje' => 'Error al eliminar el usuario',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Lista los usuarios que se asociaron por defecto a los sucesos
     * @return JsonResponse
     * @author AlejoSR
     */
    public function listarUsuarioDefecto(): JsonResponse
    {
        try {
            $usuariosDefecto = $this->usuarioSucesoService->listarUsuarioDefecto();
            return response()->json([
                'res' => true,
                'data' => $usuariosDefecto
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar los usuarios',
                'error' => $th->getMessage()
            ], 400);
        }
    }   

}
