<?php

namespace App\Http\Modules\PrestadoresTH\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Empleados\Requests\ActualizarEmpleadoRequest;
use App\Http\Modules\PrestadoresTH\Models\PrestadorTh;
use App\Http\Modules\PrestadoresTH\Requests\CrearPrestadorThRequest;
use App\Http\Modules\PrestadoresTH\Repositories\PrestadorThRepository;
use App\Http\Modules\PrestadoresTH\Requests\ActualizarPrestadorThRequest;

class PrestadorThController extends Controller
{
    private $prestadorThRepository;

    public function __construct(){
        $this->prestadorThRepository = new PrestadorThRepository;
    }

    /**
     * lista los prestadores de talento humano
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $prestadorTh = $this->prestadorThRepository->listarPrestadores($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $prestadorTh
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar los prestadores de talento humano',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarPrestador(Request $request, $id )
    {
        try {
            $prestador = $this->prestadorThRepository->listarPrestadorTipo($request, $id);
            return response()->json($prestador);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar el prestador',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un prestador de talento humano
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearPrestadorThRequest $request):JsonResponse{
        try {
            $prestador = $this->prestadorThRepository->crear($request->validated());
            return response()->json($prestador, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un prestador de talento humano
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarPrestadorThRequest $request, PrestadorTh $id){
        try {
            $this->prestadorThRepository->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),400);
        }
    }
}
