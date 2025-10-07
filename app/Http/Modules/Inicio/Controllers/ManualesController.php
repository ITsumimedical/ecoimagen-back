<?php

namespace App\Http\Modules\Inicio\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Inicio\Repositories\ManualesRepository;
use App\Http\Modules\Inicio\Requests\CrearManualRequest;
use App\Http\Modules\Inicio\Services\ManualService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ManualesController extends Controller
{
    public function __construct(
        private ManualesRepository $manualesRepository,
        private ManualService $manualService
    ) {}

    public function listarTodos()
    {
        try {
            $manuales = $this->manualesRepository->listarTodos();
            return response()->json($manuales);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crearManual(CrearManualRequest $request)
    {
        try {
            $manuales = $this->manualService->crearManual($request->validated());
            return response()->json($manuales);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cambiarEstadoManual(Request $request)
    {
        try {
            $this->manualesRepository->cambiarEstadoManual($request->id);
            return response()->json($request->id);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarManual($manual_id, Request $request)
    {
        try {
            $manual = $this->manualesRepository->actualizarManual($manual_id, $request->all());
            return response()->json($manual);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarActivos()
    {
        try {
            $videos = $this->manualesRepository->listarActivos();
            return response()->json($videos);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}