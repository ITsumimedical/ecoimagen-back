<?php

namespace App\Http\Modules\interpretacionResultados\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\interpretacionResultados\Repositories\interpretacionResultadosRepository;
use App\Http\Modules\interpretacionResultados\Request\CrearInterpretacionResultadosRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class interpretacionResultadosController extends Controller
{
    public function __construct(
        private interpretacionResultadosRepository $interpretacionResultadosRepository,
    ) {}

    public function crear(CrearInterpretacionResultadosRequest $request)
    {
        try {
            $interpretacion = $this->interpretacionResultadosRepository->crear($request->validated());
            return response()->json($interpretacion, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
