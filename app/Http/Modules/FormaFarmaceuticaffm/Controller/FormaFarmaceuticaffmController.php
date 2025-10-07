<?php

namespace App\Http\Modules\FormaFarmaceuticaffm\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\FormaFarmaceuticaffm\Model\FormaFarmaceuticaffm;
use App\Http\Modules\FormaFarmaceuticaffm\Repositories\FormaFarmaceuticaffmRepository;
use App\Http\Modules\FormaFarmaceuticaffm\Requests\ActualizarFormaFarmaceuticaffmRequest;
use App\Http\Modules\FormaFarmaceuticaffm\Requests\CrearFormaFarmaceuticaffmRequest;
use App\Http\Modules\FormaFarmaceuticaffm\Services\FormaFarmaceuticaffmService;
use Illuminate\Http\Request;

class FormaFarmaceuticaffmController extends Controller
{
    public function __construct(
        protected FormaFarmaceuticaffmRepository $formaFarmaceuticaffmRepository,
        protected FormaFarmaceuticaffmService $formaFarmaceuticaffmService
    ) {}

    public function crearFormaFarmaceutica(CrearFormaFarmaceuticaffmRequest $request)
    {
        try {
            $forma = $this->formaFarmaceuticaffmRepository->crear($request->validated());
            return response()->json($forma);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listarFormasFarmaceuticas(Request $request)
    {
        try {
            $formas = $this->formaFarmaceuticaffmRepository->listar($request);
            return response()->json($formas);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function actualizarFormasFarmaceuticas($id, ActualizarFormaFarmaceuticaffmRequest $request)
    {
        try {
             $formas = $this->formaFarmaceuticaffmService->actualizarFormasFarmaceuticasffm($id, $request->validated());
             return response()->json($formas);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function cambiarEstado($id)
    {
        try {
            $formas = $this->formaFarmaceuticaffmService->cambiarEstado($id);
            return response()->json($formas);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()],400);
        }
    }

    public function eliminar($id)
    {
        try {
            $formas = $this->formaFarmaceuticaffmRepository->eliminar($id);
            return response()->json($formas);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

}
