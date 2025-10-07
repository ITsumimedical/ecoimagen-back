<?php

namespace App\Http\Modules\Inicio\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Inicio\Repositories\VideosRepository;
use App\Http\Modules\Inicio\Requests\CrearVideoRequest;
use App\Http\Modules\Inicio\Services\VideoService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VideosController extends Controller
{
    public function __construct(
        private VideosRepository $videosRepository,
        private VideoService $videosService
    ) {}

    public function listarTodos()
    {
        try {
            $videos = $this->videosRepository->listarTodos();
            return response()->json($videos);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crearVideo(CrearVideoRequest $request)
    {
        try {
            $video = $this->videosService->crearVideo($request->validated());
            return response()->json($video);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cambiarEstadoVideo(Request $request)
    {
        try {
            $this->videosRepository->cambiarEstadoVideo($request->id);
            return response()->json($request->id);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarVideo($video_id, Request $request)
    {
        try {
            $video = $this->videosRepository->actualizarVideo($video_id, $request->all());
            return response()->json($video);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarActivos()
    {
        try {
            $videos = $this->videosRepository->listarActivos();
            return response()->json($videos);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
