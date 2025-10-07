<?php

namespace App\Http\Modules\Pqrsf\Derechos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Pqrsf\Derechos\Repositories\DerechosRepository;
use App\Http\Modules\Pqrsf\Derechos\Requests\CrearDerechoRequest;
use App\Http\Modules\Pqrsf\Derechos\Requests\EditarDerechoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DerechosController extends Controller
{
    private $derechosRepository;

    public function __construct()
    {
        $this->derechosRepository = new DerechosRepository();
    }

    /**
     * Funcion para crear un derecho
     * @param CrearDerechoRequest $request
     * @return mixed JsonResponse
     * @author Thomas
     */
    public function crearDerecho(CrearDerechoRequest $request)
    {
        try {
            $derecho = $this->derechosRepository->crearDerecho($request->validated());
            return response()->json($derecho, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para obtener todos los Derechos
     * @return mixed Collection
     * @author Thomas
     */
    public function listarDerechos()
    {
        try {
            $derechos = $this->derechosRepository->listarDerechos();
            return response()->json($derechos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para activar/inactivar un derecho
     * @param int $derechoId
     * @return mixed JsonResponse
     * @author Thomas
     */
    public function cambiarEstadoDerecho(int $derechoId)
    {
        try {
            $derecho = $this->derechosRepository->cambiarEstadoDerecho($derechoId);
            return response()->json($derecho, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para obtener un Derecho por su id
     * @param int $derechoId
     * @return mixed JsonResponse
     * @author Thomas
     */
    public function listarDerechoPorId(int $derechoId)
    {
        try {
            $derecho = $this->derechosRepository->listarDerechoPorId($derechoId);
            return response()->json($derecho, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para editar un Derecho
     * @param int $derechoId
     * @param EditarDerechoRequest $request
     * @return mixed JsonResponse
     * @author Thomas
     */
    public function editarDerecho(int $derechoId, EditarDerechoRequest $request)
    {
        try {
            $derecho = $this->derechosRepository->editarDerecho($derechoId, $request->validated());
            return response()->json($derecho, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para obtener todos los Derechos activos
     * @return JsonResponse
     * @author Thomas
     */
    public function listarActivos()
    {
        try {
            $derechos = $this->derechosRepository->listarActivos();
            return response()->json($derechos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
