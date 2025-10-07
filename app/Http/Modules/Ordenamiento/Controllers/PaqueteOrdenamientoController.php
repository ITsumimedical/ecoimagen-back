<?php

namespace App\Http\Modules\Ordenamiento\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Ordenamiento\Requests\PaqueteOrdenamientoRequest;
use App\Http\Modules\Ordenamiento\Repositories\PaqueteOrdenamientoRepository;
use App\Http\Modules\Ordenamiento\Requests\ActualizarEstadoPaqueteOrdenamientoRequest;
use App\Http\Modules\Ordenamiento\Requests\ActualizarPaqueteOrdenamientoRequest;
use App\Http\Modules\Ordenamiento\Requests\ListarPaqueteOrdenamientoRequest;
use App\Http\Modules\Ordenamiento\Services\PaqueteOrdenamientoService;

class PaqueteOrdenamientoController extends Controller
{
    public function __construct(
        protected PaqueteOrdenamientoRepository $paqueteOrdenamientoRepository,
        protected PaqueteOrdenamientoService $paquete_ordenamiento_service
    ) {}

    /**
     * crear - crea un paquete de ordenamiento
     *
     * @param  mixed $request
     * @return void
     */
    public function crear(PaqueteOrdenamientoRequest $request)
    {
        try {
            $paquete = $this->paqueteOrdenamientoRepository->crear($request->validated());
            return response()->json($paquete, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' =>  ['Error al crear el paquete de ordenamiento' . $th->getMessage()]
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * listar - lista los paquetes de ordenamiento acorde al cmapo activo
     *
     * @param  mixed $request
     * @return void
     */
    public function listarPaquete(ListarPaqueteOrdenamientoRequest $request)
    {
        try {
            $paquete = $this->paqueteOrdenamientoRepository->listarPaquete($request->validated());
            return response()->json($paquete, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' =>  ['Error al listar el paquete de ordenamiento']
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(ActualizarPaqueteOrdenamientoRequest $request, int $id)
    {
        try {
            $pabellon =    $this->paqueteOrdenamientoRepository->actualizarPaquete($id, $request->validated());
            return response()->json($pabellon);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * cambiarEstado - actualiza el estado de un paquete de ordenamiento según su id
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function cambiarEstado(ActualizarEstadoPaqueteOrdenamientoRequest $request, int $id)
    {
        try {
            $paquete = $this->paqueteOrdenamientoRepository->actualizarPaquete($id, $request->validated());
            return response()->json($paquete);
        } catch (\Throwable $th) {
            return response()->json('Error al intentar actualizar el estado del paquete', 400);
        }
    }

    /**
     * asignarCups - asigna códigos CUP a un paquete de ordenamiento
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function asignarCups(Request $request, int $id)
    {
        try {
            $this->paquete_ordenamiento_service->asignarCups($id, $request->input('cups', []));
            return response()->json(['mensaje' => 'CUPs asignados correctamente'], 200);
        } catch (\Throwable $e) {
            return response()->json(['mensaje' => 'Error al asignar CUPs'], 500);
        }
    }

    /**
     * asignarCodesumis - asigna codesumis a un paquete de ordenamiento
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function asignarCodesumis(Request $request, int $id)
    {
        try {
            $this->paquete_ordenamiento_service->asignarCodesumis($id, $request->input('codesumis', []));
            return response()->json(['mensaje' => 'Codesumis asignados correctamente'], 200);
        } catch (\Throwable $e) {
            return response()->json(['mensaje' => 'Error al asignar Codesumis'], 500);
        }
    }

    /**
     * obtenerCups - consulta los códigos CUPs de un paquete de ordenamiento
     *
     * @param  mixed $id
     * @return void
     */
    public function obtenerCups(int $id)
    {
        try {
            $data = $this->paquete_ordenamiento_service->obtenerCups($id);
            return response()->json([true, $data]);
        } catch (\Throwable $e) {
            return response()->json([false, 'mensaje' => 'Error al obtener CUPs'], 500);
        }
    }

    /**
     * obtenerCodesumis - consulta los codesumis de un paquete de ordenamiento
     *
     * @param  mixed $id
     * @return void
     */
    public function obtenerCodesumis(int $id)
    {
        try {
            $data = $this->paquete_ordenamiento_service->obtenerCodesumis($id);
            return response()->json([true, $data]);
        } catch (\Throwable $e) {
            return response()->json([false, 'mensaje' => 'Error al obtener Codesumis'], 500);
        }
    }
}
