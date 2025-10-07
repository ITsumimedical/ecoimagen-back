<?php

namespace App\Http\Modules\Inicio\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Inicio\Repositories\BoletinesRepository;
use App\Http\Modules\Inicio\Requests\CrearBoletinRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BoletinesController extends Controller
{

    public function __construct(
        private BoletinesRepository $boletinesRepository
    ) {}

    public function listarTodos()
    {
        try {
            $boletines = $this->boletinesRepository->listarTodos();
            return response()->json($boletines);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crearBoletin(CrearBoletinRequest $request)
    {
        try {
            $video = $this->boletinesRepository->crearBoletin($request->validated());
            return response()->json($video);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cambiarEstadoBoletin(Request $request)
    {
        try {
            $this->boletinesRepository->cambiarEstadoBoletin($request->id);
            return response()->json($request->id);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarBoletin($video_id, Request $request)
    {
        try {
            $boletin = $this->boletinesRepository->actualizarBoletin($video_id, $request->all());
            return response()->json($boletin);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarActivos()
    {
        try {
            $boletines = $this->boletinesRepository->listarActivos();
            return response()->json($boletines);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
