<?php

namespace App\Http\Modules\testMchat\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\testMchat\Repositories\mChatRepository;
use App\Http\Modules\testMchat\Request\CrearmChatRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class mChatController extends Controller
{
    public function __construct(
        private mChatRepository $mChatRepository,
    ) {}

    public function crear(CrearmChatRequest $request)
    {
        try {
            $this->mChatRepository->crearMchat($request->validated());
            return response()->json('Creado con exito', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function obtenerDatos($afiliadoId)
    {
        try {
            $mchat = $this->mChatRepository->obtenerDatosporAfiliado($afiliadoId);
            return response()->json($mchat, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
