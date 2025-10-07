<?php

namespace App\Http\Modules\Transcripciones\Transcripcion\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Transcripciones\Adjunto\Repositories\AdjuntoTranscripcionRepository;
use App\Http\Modules\Transcripciones\Transcripcion\Models\Transcripcione;
use App\Http\Modules\Transcripciones\Transcripcion\Repositories\TranscripcionRepository;
use App\Http\Modules\Transcripciones\Transcripcion\Requests\ActualizarTranscripcionRequest;
use App\Http\Modules\Transcripciones\Transcripcion\Requests\CrearTranscripcionRequest;
use App\Http\Modules\Transcripciones\Transcripcion\Services\TranscripcionService;

class TranscripcionController extends Controller
{
    private $transcripcionRepository;
    private $transcripcionService;

    public function __construct(TranscripcionRepository $transcripcionRepository, TranscripcionService $transcripcionService,
                                private AdjuntoTranscripcionRepository $adjuntoTranscripcionRepository){
       $this->transcripcionRepository = $transcripcionRepository;
       $this->transcripcionService = $transcripcionService;
    }

    /**
     * lista una transcripción
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $transcripcion = $this->transcripcionRepository->listar($request);
        try {
            return response()->json([
                'res' => true,
                'data' => $transcripcion
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al listar las transcripciones',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una transcripción
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearTranscripcionRequest $request): JsonResponse
    {
        try {
            $transcripcion = $this->transcripcionService->guardarTranscripcion($request->validated());
            return response()->json([
                'res' => true,
                'data' => $transcripcion,
                'mensaje' => 'Se creo la transcripción con exito!',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear la transcripción!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function buscarAdjuntos(Request $request): JsonResponse
    {
        try {
            $transcripcion = $this->adjuntoTranscripcionRepository->buscarAdjuntos($request->afiliado_id);
            return response()->json($transcripcion, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear la transcripción!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
