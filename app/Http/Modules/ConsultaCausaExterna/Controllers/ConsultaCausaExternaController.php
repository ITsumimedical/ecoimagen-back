<?php

namespace App\Http\Modules\ConsultaCausaExterna\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\ConsultaCausaExterna\Repositories\ConsultaCausaExternaRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConsultaCausaExternaController extends Controller
{
    public function __construct(
        private ConsultaCausaExternaRepository $consultaCausaExternaRepository,
    ) {}

    public function crear(Request $request) {
        try {
            $this->consultaCausaExternaRepository->crear($request->all());
            return response()->json('Creado con éxito', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function listarConsulta(Request $request)
    {
        try {
            $consulta = $this->consultaCausaExternaRepository->listarConsultaExterna($request);
            return response()->json($consulta);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }


    public function listarActivas(Request $request)
    {
        try {
            $activas = $this->consultaCausaExternaRepository->listarActivos($request);
            return response()->json($activas);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function cambiarEstado($id)
    {
        try {
            $this->consultaCausaExternaRepository->cambiarEstado($id);
            return response()->json(['Cambiado con éxito', Response::HTTP_OK]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
