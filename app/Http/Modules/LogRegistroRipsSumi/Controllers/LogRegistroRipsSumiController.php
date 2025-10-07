<?php

namespace App\Http\Modules\LogRegistroRipsSumi\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\LogRegistroRipsSumi\Repositories\LogRegistroRipsSumiRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogRegistroRipsSumiController extends Controller
{

    public function __construct(
        protected readonly LogRegistroRipsSumiRepository $logRegistroRipsSumiRepository,
    ) {}

    /**
     * obtiene una ruta por su ID
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Jose vasquez
     */
    public function listarLogs(Request $request): JsonResponse
    {
        try {
            $logs = $this->logRegistroRipsSumiRepository->listarLogs($request->all());
            return response()->json($logs, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Ha ocurrido un error al listar los Logs'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
