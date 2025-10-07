<?php

namespace App\Http\Modules\IngresoDomiciliarios\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\IngresoDomiciliarios\Models\IngresoDomiciliario;
use App\Http\Modules\IngresoDomiciliarios\Repositories\IngresoDomiciliarioRepository;
use App\Http\Modules\IngresoDomiciliarios\Requests\ActualizarIngresoDomiciliarioRequest;
use App\Http\Modules\IngresoDomiciliarios\Requests\CrearIngresoDomiciliarioRequest;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PhpParser\Node\Stmt\Return_;

class IngresoDomiciliarioController extends Controller
{
    private $ingresoDomiciliarioRepository;

    public function __construct()
    {
        $this->ingresoDomiciliarioRepository = new IngresoDomiciliarioRepository;
    }

    /**
     * Crear un ingreso domiciliario
     *
     * @param  mixed $request
     * @return JsonResponse
     * @author Manuela
     */
    public function crearIngresoDomiciliario(CrearIngresoDomiciliarioRequest $request): JsonResponse
    {
        try {
            $domiciliario = $this->ingresoDomiciliarioRepository->crear($request->validated());
            return response()->json($domiciliario, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * listar los ingresos domiciliarios
     *
     * @param  mixed $request
     * @return JsonResponse
     * @author Manuela
     */
    public function listarIngresoDomiciliarios(Request $request): JsonResponse
    {
        try {
            $domiciliario = $this->ingresoDomiciliarioRepository->listar($request);
            return response()->json($domiciliario, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * actualizar un ingreso domiciliario
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     * @author Manuela
     */
    public function actualizarIngresoDomiciliario(ActualizarIngresoDomiciliarioRequest $request, IngresoDomiciliario $id): JsonResponse
    {
        try {
            $domiciliario = $this->ingresoDomiciliarioRepository->actualizar($id, $request->validated());
            return response()->json([
                'res' => true,
                'data' => $domiciliario,
                'mensaje' => 'Ingreso domiciliario actualizada con éxito'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * cambiar el estado de un ingreso domiciliario
     *
     * @param  mixed $request
     * @param  mixed $estado_id
     * @return JsonResponse
     * @author Manuela
     */
    public function cambiarEstadoIngresoDomiciliario(Request $request, int $estado_id): JsonResponse
    {
        try {
            $estado = $this->ingresoDomiciliarioRepository->cambiarEstado($request, $estado_id);
            return response()->json([
                'res' => true,
                'data' => $estado,
                'mensaje' => 'El estado ah sido actualizado con éxito'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(Response::HTTP_BAD_REQUEST);
        }
    }

}
