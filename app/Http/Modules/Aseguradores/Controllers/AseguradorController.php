<?php

namespace App\Http\Modules\Aseguradores\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Aseguradores\Requests\CrearAseguradorRequest;
use App\Http\Modules\Aseguradores\Models\Asegurador;
use App\Http\Modules\Aseguradores\Repositories\AseguradorRepository;
use App\Http\Modules\Aseguradores\Requests\ActualizarAseguradorRequest;
use App\Http\Modules\Aseguradores\Services\AseguradorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AseguradorController extends Controller
{
    protected $Repository;
    protected $Service;

    public function __construct() {
        $this->Repository = new AseguradorRepository;
        $this->Service = new AseguradorService;
    }

    /**
     * listar aseguradores
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function listar(Request $request)
    {
        try {
            $asegurador = $this->Repository->listar($request);
            return response()->json([
                'res' => true,
                'data' => $asegurador
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar aseguradores',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un asegurador
     * @param Request $request->all()
     * @return Response
     * @author kobatiime
     */
    public function crear(CrearAseguradorRequest $request): JsonResponse
    {
        try {
            $datos= $this->Service->prepararData($request->validated());
            $nuevoAsegurador = $this->Repository->crear($datos);
            return response()->json([
                'res' => true,
                'data' => $nuevoAsegurador,
                'mensaje' => 'Aspirante creado con exito!.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear un asegurador!',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un asegurador
     * @param Request $request
     * @param int id
     * @return Response
     * @author kobatime
     */
    public function actualizar(ActualizarAseguradorRequest $request, int $id): JsonResponse
    {
        try {
            $asegurador = $this->Repository->buscar($id);
            $asegurador->fill($request->all());
            $actualizarAsegurador = $this->Repository->guardar($asegurador);
            return response()->json([
                'res' => true,
                'data' => $actualizarAsegurador,
                'mensaje' => 'El asegurador fue actualizado con exito!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al intentar actualizar el asegurador!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * cambia el estado de una asegurador
     * @param Request $request
     * @param Entidad $asegurador
     * @return Response
     * @author kobatime
     */
    public function cambiarEstado(Request $request,Asegurador $asegurador )
    {
        try {
            $asegurador->update([
                'estado' => !$asegurador->estado
            ]);
            return response()->json($asegurador, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
