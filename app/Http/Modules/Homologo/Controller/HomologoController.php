<?php

namespace App\Http\Modules\Homologo\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\Homologo\Repositories\HomologoRepository;
use App\Http\Modules\Homologo\Services\HomologoService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomologoController extends Controller
{
    private $repository;
    private $service;

    public function __construct(){
        /** Inicializar los atributos, Repository y Services */
        $this->repository = new HomologoRepository();
        $this->service = new HomologoService();
    }

    /**
     * lista el homologo
     * @param Request $request
     * @return Response
     * @author kobatime
     */
    public function listar(Request $request)
    {
        try {
            $homologo = $this->repository->listarHomologo($request);
            return response()->json([
                'res' => true,
                'data'=> $homologo
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error'=> $th->getMessage(),
                'mensaje' => 'Error al recuperar la información',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Subir Archivo
     * @param  mixed $request
     * @return void
     * @author Kobatime
     */
    public function subirArchivo(Request $request) {

        try {
            $file = $request->file('file');
            $homologo = $this->service->cagar($file);

            if($homologo['resultado'] == false){
                return response()->json([
                    'res' => false,
                    'mensaje' => $homologo['Error'],
                ], 404);
            }

            return response()->json([
                'res' => true,
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al cargar el archivo',
            ], Response::HTTP_BAD_REQUEST);
        }

    }
}
