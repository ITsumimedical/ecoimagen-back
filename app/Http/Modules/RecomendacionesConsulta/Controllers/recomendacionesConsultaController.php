<?php

namespace App\Http\Modules\RecomendacionesConsulta\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\RecomendacionesConsulta\Repositories\recomendacionesConsultaRepository;
use App\Http\Modules\RecomendacionesConsulta\Requests\CrearRecomendacionesConsultaRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class recomendacionesConsultaController extends Controller
{
    public function __construct(
        private recomendacionesConsultaRepository $recomendacionesConsultaRepository,
    ) {}

    public function crear(CrearRecomendacionesConsultaRequest $request)
    {
        try {
            $recomendaciones = $this->recomendacionesConsultaRepository->crear($request->validated());
            return response()->json($recomendaciones, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function listar($consulta_id)
    {
        try {
            $recomendaciones = $this->recomendacionesConsultaRepository->listarRecomendacion($consulta_id);
            return response()->json($recomendaciones);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
