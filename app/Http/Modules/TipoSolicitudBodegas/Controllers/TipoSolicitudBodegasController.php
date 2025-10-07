<?php

namespace App\Http\Modules\TipoSolicitudBodegas\Controllers;

use App\Http\Modules\TipoSolicitudBodegas\Repositories\TipoSolicitudBodegasRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;


class TipoSolicitudBodegasController extends Controller
{
    private $tipoSolicitudBodegasRepository;

    public function __construct(TipoSolicitudBodegasRepository $tipoSolicitudBodegasRepository){
        $this->tipoSolicitudBodegasRepository = $tipoSolicitudBodegasRepository;
    }

    /**
     * lista los tipo solicitud bodegas
     * @param Request $request
     * @return Response
     * @author julian
     */
    public function listar(Request $request)
    {
//        try {
//            $page = $request['page'] ?? 5;
            $tipoSolicitudBodegas = $this->tipoSolicitudBodegasRepository->listar($request);
            return response()->json($tipoSolicitudBodegas,Response::HTTP_OK);
//        } catch (\Throwable $th) {
//            return response()->json([
//                'res' => false,
//                'mensaje' => 'Error al recuperar tipos de solicitudes de bodegas',
//            ], Response::HTTP_BAD_REQUEST);
//        }
    }


}
