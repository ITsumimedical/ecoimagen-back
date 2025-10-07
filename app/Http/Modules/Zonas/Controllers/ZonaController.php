<?php

namespace App\Http\Modules\Zonas\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Zonas\Models\Zonas;
use App\Http\Modules\Zonas\Repositories\ZonaRepository;
use App\Http\Modules\Zonas\Requests\CrearZonaRequest;
use App\Http\Modules\Zonas\Services\ZonaService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ZonaController extends Controller
{
    public function __construct(private ZonaRepository $zonaRepository, private ZonaService $zonaService) {}

    /**
     * Crea una nueva zona
     * @param CrearZonaRequest $request
     * @return Response
     * @author Jose Vasquez
     */

    public function crearZona(CrearZonaRequest $request)
    {
        try {
            $crear = $this->zonaService->crearZona($request->validated());
            return response()->json($crear, 200);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'error' => $th->getMessage(),
                    'mensaje' => 'Ha ocurrido un error al crear la Zona'
                ],
                $th->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * lista los tipos de rutas
     * @param Request $request
     * @return Response
     * @author Jose vasquez
     */
    public function listarZonas(Request $request)
    {
        try {
            $listar = $this->zonaRepository->listarZonas($request->all());
            return response()->json($listar, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' => $th->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR

            ]);
        }
    }

    /**
     * Actualiza Zona
     * @param Request $request
     * @return Response
     * @author jose vasquez
     */

    public function actualizarZona(Request $request)
    {

        try {
            $actualizar = $this->zonaService->actualizarZona($request->all());
            return response()->json($actualizar, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al Actualizar la Zona.'
            ]);
        }
    }

    /**
     * Cambiar estado de zona
     * @param int $id
     * @return Response
     * @author jose vasquez
     */
    public function cambiarEstado(int $id)
    {
        try {

            $estado = $this->zonaService->cambiarEstado($id);
            return response()->json($estado, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al cambiar el Estado.'
            ], 500);
        }
    }
}
