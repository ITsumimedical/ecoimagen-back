<?php

namespace App\Http\Modules\Chat\Controllers;

use App\Events\SendMenssageBitacoraEvent;
use App\Http\Controllers\Controller;
use App\Http\Modules\Chat\Repositories\MensajeRepository;
use App\Http\Modules\Chat\Services\MensajeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class MensajeController extends Controller
{
    protected $repository;
    protected $Service;

    public function __construct(MensajeRepository $mensajerepository, MensajeService $mensajeservice)
    {
        $this->repository = $mensajerepository;
        $this->Service = $mensajeservice;
    }

    /**
     * listar chats
     * @param int $user_id
     * @return Response $categoriaHistoria
     * @author kobatime
     */
    public function listar(int $canal_id): JsonResponse
    {
        try {
            $mensajes = $this->repository->listar($canal_id);
            return response()->json([
                'res' => true,
                'data' => $mensajes,
                'mensaje' => 'Mensaje enviado con exito.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al enviar el mensaje',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un mensaje
     * @param Request $request
     * @return Response $mensaje
     * @author kobatime
     */
    public function crear(Request $request): JsonResponse
    {
        try {

            $mensaje = $this->repository->guardarMensaje($request->all());

            event(new SendMenssageBitacoraEvent($mensaje));

            return response()->json([
                'res' => true,
                'mensaje' => 'Mensaje enviado con exito.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al enviar el mensaje',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un adjunto
     * @param Request $request
     * @return Response $mensaje
     * @author kobatime
     */
    public function crearAdjunto(Request $request): JsonResponse
    {
        try {
            $mensaje = $this->Service->guardarAdjuntos($request);

            event(new SendMenssageBitacoraEvent($mensaje));

            return response()->json([
                'res' => true,
                'mensaje' => 'Adjunto almacenado con exito.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al almacenar el adjunto',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * marcar mensajes como vistos
     * @param Request $request
     * @author David Peláez
     */
    public function marcarVisto(Request $request, int $id)
    {
        try {
            $this->Service->marcarVisto($id);
            return response()->json(true, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function exportarChat(int $canal_id)
    {
        try {
            $consulta = $this->Service->exportarChat($canal_id);
            return response()->json($consulta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
