<?php

namespace App\Http\Modules\Pqrsf\IpsPqrsf\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Pqrsf\IpsPqrsf\Request\CrearIpsPqrsfRequets;
use App\Http\Modules\Pqrsf\IpsPqrsf\Repositories\IpsPqrsfRepository;
use App\Http\Modules\Pqrsf\IpsPqrsf\Request\ActualizarIpsPqrsfRequest;
use App\Http\Modules\Pqrsf\IpsPqrsf\Services\IpsPqrsfService;

class ipsPqrsfController extends Controller
{
    private $ipsRepository;

    public function __construct(private IpsPqrsfService $ipsPqrsfService)
    {
        $this->ipsRepository = new IpsPqrsfRepository();
    }

    public function crear(CrearIpsPqrsfRequets $request): JsonResponse
    {
        try {
            $ips = $this->ipsPqrsfService->crearIps($request->validated());
            return response()->json($ips, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarIps(Request $request)
    {
        try {
            $ips = $this->ipsRepository->listarIps($request);
            return response()->json($ips, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'Mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }



    public function eliminar(Request $request)
    {
        try {
            $ips = $this->ipsRepository->eliminar($request);

            return response()->json($ips, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear la medicmanto de PQRSF!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza las ips de un PQRSF
     * @param int $pqrsfId
     * @param ActualizarIpsPqrsfRequest $request
     * @return JsonResponse
     * @author Thomas
     */
    public function actualizarIps(int $pqrsfId, ActualizarIpsPqrsfRequest $request)
    {
        try {
            $respuesta = $this->ipsRepository->actualizarIps($pqrsfId, $request->validated());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function removerIps(int $pqrsfId, Request $request): JsonResponse
    {
        try {
            $respuesta = $this->ipsRepository->removerIps($pqrsfId, $request->all());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
