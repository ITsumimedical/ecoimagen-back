<?php

namespace App\Http\Modules\PreguntasTest\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\PreguntasTest\Repositories\preguntasTipoTestRepository;
use App\Http\Modules\PreguntasTest\Request\CrearpreguntasTipoTestRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class preguntasTipoTestController extends Controller
{
    public function __construct(
        private preguntasTipoTestRepository $preguntasTipoTestRepository,
    ) {}

    public function crearPreguntas(CrearpreguntasTipoTestRequest $request)
    {
        try {
            $preguntas = $this->preguntasTipoTestRepository->crear($request->validated());
            return response()->json($preguntas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function listar()
    {
        try {
            $preguntas = $this->preguntasTipoTestRepository->listarPreguntas();
            return response()->json($preguntas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function listarPorNombreTest(Request $request)
    {
        $nombreTest = $request->input('nombre_test');

        try {
            $preguntas = $this->preguntasTipoTestRepository->listarPreguntasPorNombreTest($nombreTest);
            return response()->json($preguntas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(Request $request, $id)
    {
        try {
            $preguntasTipoTest = $this->preguntasTipoTestRepository->buscar($id);
            $this->preguntasTipoTestRepository->actualizar($preguntasTipoTest, $request->all());
            return response()->json($preguntasTipoTest, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al actualizar la pregunta', $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
