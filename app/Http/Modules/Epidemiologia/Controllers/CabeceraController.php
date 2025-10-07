<?php

namespace App\Http\Modules\Epidemiologia\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Epidemiologia\Repositories\CabeceraRepository;
use App\Http\Modules\Epidemiologia\Requests\CrearCabeceraRequest;
use App\Http\Modules\Epidemiologia\Services\CabeceraService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CabeceraController extends Controller
{
    public function __construct(private CabeceraService $cabeceraService, private CabeceraRepository $cabeceraRepository)
    {

    }

    public function listarCabeceras(Request $request){
        try {
            $listarCabeceras = $this->cabeceraService->listarCabeceras($request->all());
            return response()->json($listarCabeceras, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al listar las cabeceras',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crearCabeceras(CrearCabeceraRequest $request){
        try {
            $crearCabecera = $this->cabeceraRepository->crearCabecera($request->validated());
            return response()->json($crearCabecera, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error al listar las cabeceras'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para actulizar cabecera epidemiologico
     * @author Sofia O
     */
    public function actualizarCabeceras(CrearCabeceraRequest $request, $id)
    {
        try {
            $actualizarCabecera = $this->cabeceraService->actualizarcabecera($request->validated(), $id);
            return response()->json($actualizarCabecera, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'messaje' => 'Error al actualizar el cabecera'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para cambiar el estado del cabecera
     * @author Sofia O
     */
    public function cambiarEstadoCabecera($id)
    {
        try {
            $cambiarEstado = $this->cabeceraService->actualizarEstado($id);
            return response()->json($cambiarEstado, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'messaje' => 'Error al cambiar el estado del cabecera'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
