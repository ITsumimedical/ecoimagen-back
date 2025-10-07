<?php

namespace App\Http\Modules\Estados\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Estados\Requests\CrearEstadoRequest;
use App\Http\Modules\Estados\Repositories\EstadoRepository;
use App\Http\Modules\Estados\Requests\ActualizarEstadoRequest;

class EstadoController extends Controller
{
    private $estadoRepository;

    public function __construct(EstadoRepository $estadoRepository)
    {
        $this->estadoRepository = $estadoRepository;
    }

    /**
     * lista los estados
     * @param Request $request
     * @return Response
     * @author Manuela
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $estados = $this->estadoRepository->listar($request);
            return response()->json($estados, Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al listar los estados',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Crea un estado
     * @param Request $request
     * @return Response
     * @author Manuela
     */
    public function crear(CrearEstadoRequest $request): JsonResponse
    {
        try {
            $this->estadoRepository->crear($request->validated());
            return response()->json([
                'mensaje' => 'Estado creado con exito!.',
            ], Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al crear estado',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * actualizar un estado
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     * @author Manuela
     */
    public function actualizar(ActualizarEstadoRequest $request, int $id): JsonResponse
    {
        try {
            $estado = $this->estadoRepository->buscar($id);
            $estado->fill($request->validated());
            $this->estadoRepository->guardar($estado);
            return response()->json([
                'mensaje' => 'Estado actualizado con exito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al actualizar estado'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
