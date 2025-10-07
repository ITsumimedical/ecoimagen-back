<?php

namespace App\Http\Modules\MesaAyuda\AreasMesaAyuda\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\MesaAyuda\AreasMesaAyuda\Repositories\AreasMesaAyudaRepository;

class AreasMesaAyudaController extends Controller
{
    public function __construct(private AreasMesaAyudaRepository $areasMesaAyudaRepository) {
    }

    public function listar(Request $request)
    {
        try {
            $responsable = $this->areasMesaAyudaRepository->listarArea($request);
            return response()->json($responsable, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'Error al recuperar las areas',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(Request $request){
        try {
            $responsable = $this->areasMesaAyudaRepository->crear($request->all());
            return response()->json($responsable , Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(Request $request, int $id)
    {
        try {
            $area = $this->areasMesaAyudaRepository->buscar($id);
            $area->fill($request->all());
            $responsableUpdate = $this->areasMesaAyudaRepository->guardar($area);
            return response()->json($area, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar el area',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cambiarEstado(int $id)
    {
        try {
            $area = $this->areasMesaAyudaRepository->cambiarEstado($id);
            return response()->json($area, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al cambiar el estado del area',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
