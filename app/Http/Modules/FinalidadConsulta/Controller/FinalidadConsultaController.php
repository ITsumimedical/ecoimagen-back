<?php

namespace App\Http\Modules\FinalidadConsulta\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\FinalidadConsulta\Model\FinalidadConsulta;
use App\Http\Modules\FinalidadConsulta\Repositories\FinalidadConsultaRepository;
use App\Http\Modules\FinalidadConsulta\Requests\CrearFinalidadConsultaRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FinalidadConsultaController extends Controller
{
    public function __construct(
        private FinalidadConsultaRepository $finalidadConsultaRepository,
    ) {}

    public function crear(CrearFinalidadConsultaRequest $request) {
        try {
            $this->finalidadConsultaRepository->crear($request->validated());
            return response()->json('Creado con éxito', Response::HTTP_CREATED);
         } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function listar(Request $request) {
        try {
            $finalidad = $this->finalidadConsultaRepository->listarFinalidades($request);
            return response()->json($finalidad);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function listarActivas(Request $request)
    {
        try {
            $activas = $this->finalidadConsultaRepository->listarActivas($request);
            return response()->json($activas);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function actualizar(Request $request, FinalidadConsulta $finalidadModel) {
        try {
            $this->finalidadConsultaRepository->actualizar($request,$finalidadModel);
            return response()->json('Actualizado con exito', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function cambiarEstado($id)
    {
        try {
            $this->finalidadConsultaRepository->cambiarEstado($id);
            return response()->json(['Cambiado con éxito', Response::HTTP_OK]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
