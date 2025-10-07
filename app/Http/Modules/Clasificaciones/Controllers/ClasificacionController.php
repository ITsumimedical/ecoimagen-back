<?php

namespace App\Http\Modules\Clasificaciones\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Clasificaciones\Models\clasificacion;
use App\Http\Modules\Clasificaciones\Services\ClasificacionService;
use App\Http\Modules\Clasificaciones\Requests\CrearClasificacionRequest;
use App\Http\Modules\Clasificaciones\Repositories\ClasificacionRepository;
use App\Http\Modules\Clasificaciones\Requests\ActualizarClasificacionRequest;

class ClasificacionController extends Controller
{
   protected $ClasificacionRepository;
   protected $ClasificacionService;

   public function __construct()
   {
     $this->ClasificacionRepository = new ClasificacionRepository();
     $this->ClasificacionService = new ClasificacionService();
   }

    /**
     * Lista las clasificaciones
     * @param Request $request
     * @return Response $listarClasificacion
     * @author kobatime
     */
    public function listar(Request $request)
    {
        try {
            $listarClasificacion = $this->ClasificacionRepository->listar($request);
            return response()->json($listarClasificacion,200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar el clasificación',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Crear la clasificacion
     * @param Request $request
     * @return $crearRegistro
     * @author kobatime
     */

    public function crear(CrearClasificacionRequest $request){
        try {
             // se usa servicio para añadir el usuario quien crear el tipo de marcacion
            $AgregarUser = $this->ClasificacionService->prepararData($request->validated());
             //se envia la data a repository
            $crearRegistro = $this->ClasificacionRepository->crear($AgregarUser);
            return response()->json([
                'res' => true,
                'data' => $crearRegistro,
                'mensaje' => 'La clasificacioncreada con exito!.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'Error' => $th->getMessage(),
                'mensaje' => 'Error al crear la clasificación',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualizar tipo de marcacion
     * @param Request $request, $tipoMarcacionAfiliado
     * @return $actualizarTipoMarcacionAfiliado
     * @author kobatime
     */
    public function actualizar(ActualizarClasificacionRequest $request, clasificacion $id){
        try {
            $actualizarClasifiacion = $this->ClasificacionRepository->actualizar($id,$request->validated());
            return response()->json([
                'res' => true,
                'data' => $actualizarClasifiacion,
                'mensaje' => 'La clasificación Actualizada con exito!.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar la clasificación',
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function actualizarEstado(ActualizarClasificacionRequest $request, int $id): JsonResponse
    {
        try {
            // se busca el tipo de afliado
            $clasificacionAfiliado = $this->ClasificacionRepository->buscar($id);
            // se realiza una comparacion de los datos
            $clasificacionAfiliado->fill($request->all());
            // se envia los datos al repositorio
            $clasificacion = $this->ClasificacionRepository->guardar($clasificacionAfiliado);

            return response()->json([
                'res' => true,
                $clasificacion,
                'mensaje' => 'clasificación actualizada con exito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar la clasificación'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
