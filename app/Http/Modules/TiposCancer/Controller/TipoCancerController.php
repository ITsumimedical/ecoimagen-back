<?php

namespace App\Http\Modules\TiposCancer\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\TiposCancer\Repositories\TipoCancerRepository;
use App\Http\Modules\TiposCancer\Requests\ActualizarTipoCancerRequest;
use App\Http\Modules\TiposCancer\Requests\AgregarCie10TipoCancerRequest;
use App\Http\Modules\TiposCancer\Requests\CrearTipoCancerRequest;
use App\Http\Modules\TiposCancer\Services\TipoCancerService;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Node\FunctionNode;

class TipoCancerController extends Controller
{
       public function __construct(
        protected TipoCancerRepository $tipoCancerRepository,
        protected TipoCancerService $tipoCancerService
    ) {}

    public function crearTipoCancer(CrearTipoCancerRequest $request)
    {
        try {
            $cancer = $this->tipoCancerRepository->crear($request->validated());
            return response()->json($cancer, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listar(Request $request) {
        try {
            $cancers = $this->tipoCancerRepository->listar($request);
            return response()->json($cancers);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function actualizarTipoCancer($id, ActualizarTipoCancerRequest $request)
    {
        try {
            $cancer = $this->tipoCancerService->actualizar($id, $request->validated());
            return response()->json($cancer);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function agregarCie10TipoCancer(AgregarCie10TipoCancerRequest $request)
    {
        try {
            $cancer = $this->tipoCancerService->agregarCie10TipoCancer($request->validated());
            return response()->json($cancer);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listarCie10TipoCancer(int $id)
    {
        try {
            $cie10s = $this->tipoCancerRepository->listarCie10TipoCancer($id);
            return response()->json($cie10s);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function obtenerTipoCancerPorCie10(int $cie10_id)
    {
        try {
            $cancer = $this->tipoCancerRepository->obtenerTipoCancerPorCie10($cie10_id);
            return response()->json($cancer);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
