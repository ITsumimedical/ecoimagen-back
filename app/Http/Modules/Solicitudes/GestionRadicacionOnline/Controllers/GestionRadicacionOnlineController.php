<?php

namespace App\Http\Modules\Solicitudes\GestionRadicacionOnline\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Solicitudes\GestionRadicacionOnline\Repositories\GestionRadicacionOnlineRepository;
use App\Http\Modules\Solicitudes\GestionRadicacionOnline\Requests\CrearGestionRequest;
use App\Http\Modules\Solicitudes\GestionRadicacionOnline\Services\GestionRadicacionOnlineService;

class GestionRadicacionOnlineController extends Controller
{
    public function __construct( private GestionRadicacionOnlineRepository $gestionRadicacionOnlineRepository,
                                 private GestionRadicacionOnlineService $gestionRadicacionOnlineService) {
    }

    public function verComentariosPublicos(Request $request){
        try {
          $comentario =  $this->gestionRadicacionOnlineRepository->verComentariosPublicos($request->all());
          return response()->json($comentario, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function verComentariosPrivados(Request $request){
        try {
          $comentario =  $this->gestionRadicacionOnlineRepository->verComentariosPrivados($request->all());
          return response()->json($comentario, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function verDevoluciones(Request $request){
        try {
          $comentario =  $this->gestionRadicacionOnlineRepository->verDevoluciones($request->all());
          return response()->json($comentario, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function guardarGestion(CrearGestionRequest $request){
        try {
            $gestion =  $this->gestionRadicacionOnlineService->gestion($request->validated());
            return response()->json($gestion, Response::HTTP_CREATED);
          } catch (\Throwable $th) {
              return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
          }
    }
}
