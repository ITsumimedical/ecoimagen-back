<?php

namespace App\Http\Modules\unidadesMedidasMedicamentos\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\unidadesMedidasMedicamentos\Repositories\UnidadesMedidasMedicamentosRepository;
use App\Http\Modules\unidadesMedidasMedicamentos\Requests\ActualizarUnidadesMedidasMedicamentosRequest;
use App\Http\Modules\unidadesMedidasMedicamentos\Requests\CrearUnidadesMedidasMedicamentosRequest;
use App\Http\Modules\unidadesMedidasMedicamentos\Services\UnidadesMedidasMedicamentosService;
use Illuminate\Http\Request;

class UnidadesMedidasMedicamentosController extends Controller
{
    public function __construct(
        protected UnidadesMedidasMedicamentosRepository $unidadesMedicamentosRepository,
        protected UnidadesMedidasMedicamentosService $unidadeMedidasMedicamentos
    ) {}

    public function crear(CrearUnidadesMedidasMedicamentosRequest $request) {
        try {
            $unidades = $this->unidadesMedicamentosRepository->crear($request->validated());
            return response()->json($unidades);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listarUnidadesMedida(Request $request){
        try {
            $unidades = $this->unidadesMedicamentosRepository->listar($request);
            return response()->json($unidades);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()],400);
        }
    }

    public function actualizar($id, ActualizarUnidadesMedidasMedicamentosRequest $request)
    {
        try {
            $unidades = $this->unidadeMedidasMedicamentos->actualizar($id, $request->validated());
            return response()->json($unidades);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()],400);
        }
    }

    public function eliminar($id)
    {
        try {
            $unidades = $this->unidadesMedicamentosRepository->eliminar($id);
            return response()->json($unidades);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
