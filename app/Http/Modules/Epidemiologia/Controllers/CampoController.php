<?php

namespace App\Http\Modules\Epidemiologia\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Epidemiologia\Repositories\CampoRepository;
use App\Http\Modules\Epidemiologia\Requests\CondicionCampoRequest;
use App\Http\Modules\Epidemiologia\Requests\CrearCampoRequest;
use App\Http\Modules\Epidemiologia\Services\CampoService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CampoController extends Controller
{
    public function __construct(private CampoService $campoService, private CampoRepository $campoRepository) {}

    /**
     * Funcion para listar los campos de la ficha epidemiologica
     * @author Sofia O
     */
    public function listarCampos(Request $request)
    {
        try {
            $listarCampos = $this->campoService->listarCampos($request->all());
            return response()->json($listarCampos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Hubo un error al listar los campos'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para crear el campo de la ficha epidemiologica
     * @author Sofia O
     */
    public function crearCampos(CrearCampoRequest $request)
    {
        try {
            $crearCampos = $this->campoRepository->crearCampo($request->validated());
            return response()->json($crearCampos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Hubo un error al crear el campo'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para actulizar campo de la ficha epidemiologica
     * @author Sofia O
     */
    public function actualizarcampos(CrearCampoRequest $request, $id)
    {
        try {
            $actualizarCampo = $this->campoService->actualizarCampo($request->validated(), $id);
            return response()->json($actualizarCampo, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'messaje' => 'Error al actualizar el campo'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para cambiar el estado del campo
     * @author Sofia O
     */
    public function cambiarEstadoCampo($id)
    {
        try {
            $cambiarEstado = $this->campoService->actualizarEstado($id);
            return response()->json($cambiarEstado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'messaje' => 'Error al cambiar el estado del campo'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para listar los campos de la ficha epidemiologica por evento
     * @author Sofia O
     */
    public function listarCamposPorEvento(Request $request)
    {
        try {
            $listarCampos = $this->campoRepository->listarCamposEventoId($request->all());
            return response()->json($listarCampos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Hubo un error al listar los campor por evento'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para añadir a los campos condiciones segun otro campo
     * @author Sofia O
     */
    public function agregarCondicion(CondicionCampoRequest $request, $id)
    {
        try {
            $agregarCondicion = $this->campoService->agregarCondicionCampo($request->validated(), $id);
            return response()->json($agregarCondicion, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Hubo un error al agregar la condicion'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
