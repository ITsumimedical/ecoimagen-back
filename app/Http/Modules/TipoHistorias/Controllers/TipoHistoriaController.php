<?php

namespace App\Http\Modules\TipoHistorias\Controllers;

use App\Http\Modules\TipoHistorias\Repositories\TipoHistoriaRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\TipoHistorias\Request\ActualizarTipoHistoriaRequest;
use App\Http\Modules\TipoHistorias\Request\AgregarComponentesTipoHistoriaRequest;
use App\Http\Modules\TipoHistorias\Request\CrearTipoHistoriaRequest;
use App\Http\Modules\TipoHistorias\Services\TipoHistoriaService;

class TipoHistoriaController extends Controller
{


    public function __construct(
        protected TipoHistoriaRepository $repository,
        protected TipoHistoriaService $tipoHistoriaService
    ) {}

    /**
     * lista los tipo historia
     * @return void
     * @return JsonResponse
     * @author Jonathan Cobaleda
     */
    public function listar(){
        try {
            $tipos_Historia = $this->repository->listarTipoHistoria();
            return response()->json($tipos_Historia);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * crearTipoHistoria
     * Funcion para crear tipos de historia
     *
     * @param  mixed $request
     * @return void
     * @author Serna
     */
    public function crearTipoHistoria(CrearTipoHistoriaRequest $request)
    {
        try {
            $tipoHistorias = $this->repository->crear($request->validated());
            return response()->json($tipoHistorias);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()],400);
        }
    }

    public function actualizar($id, CrearTipoHistoriaRequest $request)
    {
        try {
            $tipo_historia = $this->tipoHistoriaService->actualizar($id,$request->validated());
            return response()->json($tipo_historia);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function agregarComponentesTipoHistoria(AgregarComponentesTipoHistoriaRequest $request)
    {
        try {
            $componentes = $this->tipoHistoriaService->agregarComponentesTipoHistoria($request->validated());
            return response()->json($componentes);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listarComponentesTipoHistoria($tipo_historia_id)
    {
        try {
            $componentes = $this->tipoHistoriaService->obtenerComponentesTipoHistoria($tipo_historia_id);
            return response()->json($componentes);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
