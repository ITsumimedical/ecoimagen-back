<?php

namespace App\Http\Modules\TipoRutas\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\TipoRutas\Models\TipoRuta;
use App\Http\Modules\TipoRutas\Repositories\TipoRutaRepository;
use App\Http\Modules\TipoRutas\Requests\CrearTipoRutaRequest;
use App\Http\Modules\TipoRutas\Services\TipoRutaService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TipoRutaController extends Controller
{

    public function __construct(private TipoRutaService $tipoRutaService,private TipoRutaRepository $tipoRutaRepository)
    {}

    public function crearTipoRuta(CrearTipoRutaRequest $request)
    {
        try {
            $respuesta = $this->tipoRutaService->crearTipoRuta($request->validated());
            return response()->json($respuesta);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'error' => $th->getMessage(),
                    'mensaje' => 'Error al crear Tipo Ruta'
                ],
                $th->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    public function listarTodas(Request $request){
        try {
            $respuesta = $this->tipoRutaRepository->listarTodas($request->all());
            return response()->json($respuesta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'Error' => $th->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR

            ]);

        }
    }

    /**
     * Lista una ruta por su id
     * @param Request $request
     * @param TipoRuta
     * @return Response
     * @author josevq
     */
    public function listarRutaPorId(Request $request, TipoRuta $ruta){
        try {
            return response()->json($ruta);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error en el Id de la Ruta'
            ]);
        }
    }

    /**
     *
     */
    public function actualizarRuta(Request $request, TipoRuta $ruta){
        try {
            $ruta = $this->tipoRutaService->actualizarRuta($request->all(), $ruta);
            return response()->json($ruta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al Actualizar la Ruta.'
            ]);
        }
    }
}


