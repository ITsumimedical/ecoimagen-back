<?php

namespace App\Http\Modules\EntidadesCodesumiParametrizacion\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\EntidadesCodesumiParametrizacion\Repositories\CodesumiEntidadRepository;
use App\Http\Modules\EntidadesCodesumiParametrizacion\Requests\ActualizarCodesumiEntidadRequest;
use App\Http\Modules\EntidadesCodesumiParametrizacion\Requests\AgregarProgramasCodesumiEntidadRequest;
use App\Http\Modules\EntidadesCodesumiParametrizacion\Requests\CodesumiEntidadRequest;
use App\Http\Modules\EntidadesCodesumiParametrizacion\Services\CodesumiEntidadService;
use Illuminate\Http\Request;

class CodesumiEntidadController extends Controller
{
    public function __construct(
        protected CodesumiEntidadService $codesumiEntidadService,
        protected CodesumiEntidadRepository $codesumiEntidadRepository
    ) {}

    public function crearParametrizacionCodesumi(CodesumiEntidadRequest $request)
    {
       try {
            $codesumi = $this->codesumiEntidadService->crearParametrizacionCodesumi($request->validated());
            return response()->json($codesumi);
       } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
       }
    }

    public function listarParametrizacionesCodesumi($codesumi_id){
        try {
            $parametrizaciones = $this->codesumiEntidadRepository->listarParametrizacionesCodesumi($codesumi_id);
            return response()->json($parametrizaciones);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function actualizarParametrizacionEntidad($id, ActualizarCodesumiEntidadRequest $request){
        try {
           $codesumi = $this->codesumiEntidadService->actualizarParametrizacionEntidad($id, $request->validated());
            return response()->json($codesumi);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function agregarCodesumisPrograma($id, AgregarProgramasCodesumiEntidadRequest $request)
    {
        try {
            $codesumi = $this->codesumiEntidadService->agregarProgramasCodesumiEntidad([$id], $request->validated());
            return response()->json($codesumi);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}


