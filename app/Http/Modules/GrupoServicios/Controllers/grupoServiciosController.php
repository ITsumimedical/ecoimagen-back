<?php

namespace App\Http\Modules\GrupoServicios\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\GrupoServicios\Repositories\grupoServiciosRepository;
use App\Http\Modules\GrupoServicios\Request\CreargrupoServiciosRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class grupoServiciosController extends Controller
{
    public function __construct(
        private grupoServiciosRepository $grupoServiciosRepository,
    ) {}

    public function listar(Request $request)
    {
        try {
            $grupoServicio = $this->grupoServiciosRepository->listar($request);
            return response()->json($grupoServicio);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }

    public function crearServicio(CreargrupoServiciosRequest $request)
    {
        try {
            $grupo = $this->grupoServiciosRepository->crear($request->validated());
            return response()->json($grupo, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([$th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(Request $request, int $id)
    {
        try {
            $modalidad = $this->grupoServiciosRepository->update($id, $request->all());
            return response()->json(['Actualizado con éxito', Response::HTTP_OK]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
