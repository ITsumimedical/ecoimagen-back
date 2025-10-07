<?php

namespace App\Http\Modules\TipoTest\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\TipoTest\Repositories\tipoTestRepository;
use App\Http\Modules\TipoTest\Requets\CreartipoTestRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class tipoTestController extends Controller
{
    public function __construct(
        private tipoTestRepository $tipoTestRepository,
    ) {}


    public function listar(Request $request)
    {
        try {
            $test = $this->tipoTestRepository->listar($request);
            return response()->json($test);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function crearTipoTest(CreartipoTestRequest $request)
    {
        try {
            $tipoTest = $this->tipoTestRepository->crear($request->validated());
            return response()->json($tipoTest, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['Error', $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(Request $request, $id)
    {
        try {
            $tipoTest = $this->tipoTestRepository->buscar($id);
            $this->tipoTestRepository->actualizar($tipoTest, $request->all());
            return response()->json($tipoTest, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al actualizar el tipo de test', $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }


}
