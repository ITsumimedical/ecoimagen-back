<?php

namespace App\Http\Modules\Caracterizacion\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Afiliados\Repositories\AfiliadoRepository;
use App\Http\Modules\Caracterizacion\Repositories\EncuestaRepository;
use App\Http\Modules\Caracterizacion\Requests\ActualizarEncuestaRequest;
use App\Http\Modules\Caracterizacion\Requests\CrearEncuestaRequest;
use App\Http\Modules\Caracterizacion\Services\EncuestaService;
use Illuminate\Http\Response;

class EncuestaController extends Controller
{
    public function __construct(
        private EncuestaRepository $encuestaRepository,
        private EncuestaService $encuestaService,
        private AfiliadoRepository $afiliadoRepository
    ) {
    }

    /**
     * Crea una encuesta
     * @author Manuela
     * @param array $data
     * @return Encuesta
     */
    public function crearEncuesta(CrearEncuestaRequest $request)
    {
        try {
            $encuesta = $this->encuestaService->crearEncuesta($request->validated());

            return response()->json([$encuesta,
                'mensaje' => 'Encuesta creada con éxito'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'No se puede crear encuesta'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Crea una encuesta
     * @author Manuela
     * @param array $data
     * @return Encuesta
     */
    public function crearEncuestaId(int $afiliado_id)
    {
        try {
            $encuesta = $this->encuestaService->crearEncuestaId($afiliado_id);

            return response()->json([$encuesta,
                'mensaje' => 'Encuesta creada con éxito'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una encuesta
     * @author Manuela
     * @param array $data
     * @return Encuesta
     */
    public function actualizarEncuesta(ActualizarEncuestaRequest $request, int $id)
    {
        try {
            $this->encuestaService->actualizarEncuesta($id, $request->validated());
            return response()->json([
                'mensaje' => 'Encuesta actualizada con éxito'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'No se puede actualizar encuesta'
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Obtiene la caracterizacion de un afiliado
     * @author Manuela
     * @param int $afiliado_id
     * @return Encuesta con datos del afiliado
     */
    public function obtenerCaracterizacionPorAfiliado(int $afiliado_id)
    {
        try {
            $encuesta = $this->encuestaRepository->obtenerCaracterizacionDeAfiliado($afiliado_id);
            return response()->json($encuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'No se puede obtener la caracterización del afiliado',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
