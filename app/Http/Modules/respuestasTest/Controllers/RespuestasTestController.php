<?php

namespace App\Http\Modules\respuestasTest\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\respuestasTest\Repositories\RespuestasTestRepository;
use App\Http\Modules\respuestasTest\Request\CrearRespuestasTestRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RespuestasTestController extends Controller
{
    public function __construct(
        private RespuestasTestRepository $respuestasTestRepository,
    ) {}

    public function crearRespuesta(CrearRespuestasTestRequest $request)
    {
        try {
            $respuestas = $this->respuestasTestRepository->agregarRespuestas($request->validated()['respuestas']);
            return response()->json($respuestas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
