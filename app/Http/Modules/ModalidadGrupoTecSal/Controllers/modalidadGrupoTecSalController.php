<?php

namespace App\Http\Modules\ModalidadGrupoTecSal\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\ModalidadGrupoTecSal\Repositories\modalidadGrupoTecSalRepository;
use App\Http\Modules\ModalidadGrupoTecSal\Requests\CrearmodalidadGrupoTecSalRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class modalidadGrupoTecSalController extends Controller
{
    public function __construct(
        private modalidadGrupoTecSalRepository $modalidadGruposRepository,
    ) {}


    public function listar(Request $request)
    {
        try {
            $codigo = $this->modalidadGruposRepository->listar($request);
            return response()->json($codigo);
        } catch (\Throwable $th) {
            return response()->json('Error', $th->getMessage());
        }
    }


    public function crearModalidad(CrearmodalidadGrupoTecSalRequest $request)
    {
        try {
            $modalidad = $this->modalidadGruposRepository->crear($request->validated());
            return response()->json($modalidad, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function actualizar(Request $request, int $id)
    {
        try {
            $modalidad = $this->modalidadGruposRepository->update($id, $request->all());
            return response()->json(['Actualizado con éxito', Response::HTTP_OK]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
