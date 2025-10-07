<?php

namespace App\Http\Modules\TipoCitas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\TipoCitas\Models\TipoCita;
use App\Http\Modules\TipoCitas\Repositories\TipoCitaRepository;
use App\Http\Modules\TipoCitas\Requests\ActualizarTipoCitaRequest;
use App\Http\Modules\TipoCitas\Requests\GuardarTipoCitaRequest;

class TipoCitaController extends Controller
{
    protected $tipoCitaRepository;

    public function __construct(TipoCitaRepository $tipoCitaRepository) {
        $this->tipoCitaRepository = $tipoCitaRepository;
    }

    /**
     * lista los tipos de citas
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request)
    {
        try {
            $tipoCitas = $this->tipoCitaRepository->listar($request);
            return response()->json([
                'res' => true,
                'data' => $tipoCitas
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar los tipos de citas',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un tipo de cita
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(GuardarTipoCitaRequest $request): JsonResponse
    {
        try {
            $nuevoTipoCita = new TipoCita($request->all());
            $tipoCita = $this->tipoCitaRepository->guardar($nuevoTipoCita);
            return response()->json([
                'res' => true,
                'data' => $tipoCita,
                'mensaje' => 'Tipo de cita creada con exito!.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'erro' => $th->getMessage(),
                'mensaje' => 'Error al crear el tipo de cita',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(ActualizarTipoCitaRequest $request, int $id): JsonResponse
    {
        try {
            $tipoCita = $this->tipoCitaRepository->buscar($id);
            $tipoCita->fill($request->all());

            $actualizartipoCita = $this->tipoCitaRepository->guardar($tipoCita);

            return response()->json([
                'res' => true,
                'data' => $actualizartipoCita,
                'mensaje' => 'Tipo cita actualizada con exito!.'
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al actualizar el tipo de cita'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
