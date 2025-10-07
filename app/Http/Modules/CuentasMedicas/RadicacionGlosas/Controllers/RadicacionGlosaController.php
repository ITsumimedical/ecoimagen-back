<?php

namespace App\Http\Modules\CuentasMedicas\RadicacionGlosas\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\CuentasMedicas\RadicacionGlosas\Repositories\RadicacionGlosaRepository;
use App\Http\Modules\CuentasMedicas\RadicacionGlosas\Requests\CrearRadicacionRequest;
use Illuminate\Http\Response;

class RadicacionGlosaController extends Controller
{

    private $radicacionRepository;

    public function __construct(RadicacionGlosaRepository $radicacionRepository) {
        $this->radicacionRepository = $radicacionRepository;
    }


    /**
     * Crea o actualiza una radicacion de una glosa
     * @return Response $radicacion
     * @author JDSS
     */
    public function crearActualizarRadicacionGlosa(CrearRadicacionRequest $request){
        try {
            $radicacion = $this->radicacionRepository->crearActualizar($request->validated());
            return response()->json($radicacion);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>$th->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

    public function cargarArchivo(Request $request){
        try {
            $archivo = $this->radicacionRepository->cargarArchivo($request);
            return response()->json(['mensaje'=>$archivo],Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>$th->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }
}
