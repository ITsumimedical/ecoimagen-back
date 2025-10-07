<?php

namespace App\Http\Modules\ParametrizacionRemisionProgramas\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\ParametrizacionRemisionProgramas\Repositories\ParametrizacionRemisionProgramasRepository;
use App\Http\Modules\ParametrizacionRemisionProgramas\Request\CrearRemisionProgramaRequest;
use App\Http\Modules\ParametrizacionRemisionProgramas\Services\ParametrizacionRemisionProgramasService;
use Illuminate\Http\Request;

class ParametrizacionRemisionProgramasController extends Controller
{
    public function __construct(
        protected ParametrizacionRemisionProgramasRepository $parametrizacionRemisionProgramasRepository,
        protected ParametrizacionRemisionProgramasService $parametrizacionRemisionProgramasService
    ) {}

    public function crear(CrearRemisionProgramaRequest $request)
    {
        try {
            $remision = $this->parametrizacionRemisionProgramasRepository->crear($request->validated());
            return response()->json($remision);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listar(Request $request)
    {
        try {
            $programas = $this->parametrizacionRemisionProgramasRepository->listar($request);
            return response()->json($programas);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }


    public function listarPorEdadYSexo(Request $request)
    {
        try {
            $programas = $this->parametrizacionRemisionProgramasRepository->listarPorEdadYSexo($request->edad, $request->sexo);
            return response()->json($programas);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function actualizar($id,Request $request)
    {
        try {
            $programaActualizado = $this->parametrizacionRemisionProgramasService->actualizarPrograma($id,$request->all());
            return response()->json($programaActualizado);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
