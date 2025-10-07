<?php

namespace App\Http\Modules\CodigoServicio\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\CodigoServicio\Repositories\CodigoServicioRepository;
use App\Http\Modules\CodigoServicio\Request\CrearCodigoServicioRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CodigoServicioController extends Controller
{
    public function __construct(
        private CodigoServicioRepository $codigoServicioRepository,
    ) {}

    public function listar(Request $request)
    {
        try {
            $codigoServicios = $this->codigoServicioRepository->listarCodigos($request);
            return response()->json($codigoServicios);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(CrearCodigoServicioRequest $request)
    {
        try {
            $codigoServicio = $this->codigoServicioRepository->crear($request->validated());
            return response()->json($codigoServicio, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['error', $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(Request $request, int $id)
    {
        try {
            $this->codigoServicioRepository->update($id, $request->all());
            return response()->json(['Actualizado con éxito', Response::HTTP_OK]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cambiarEstado($id)
    {
        try {
            $this->codigoServicioRepository->cambiarEstado($id);
            return response()->json(['Cambiado con éxito', Response::HTTP_OK]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
