<?php

namespace App\Http\Modules\CuentasMedicas\CodigoGlosas\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\CuentasMedicas\CodigoGlosas\Repositories\CodigoGlosaRepository;
use App\Http\Modules\CuentasMedicas\CodigoGlosas\Requests\CrearCodigoGlosasRequest;
use Illuminate\Http\Request;

class CodigoGlosaController extends Controller
{

    public function __construct(private CodigoGlosaRepository $codigoGlosaRepository) {
    }

    /**
     * listar los codigo de glosas que esten activos
     * @param Request $request
     * @return Response $codigoGlosa
     * @author JDSS
     */

     public function listarCodigoGlosas(Request $request){
        try {
            $codigoGlosa = $this->codigoGlosaRepository->listarCodigoGlosas($request);
        return response()->json($codigoGlosa);
        } catch (\Throwable $th) {
            return response()->json(false);
        }
     }

     /**
     * crea los codigo de glosas
     * @param Request $request
     * @return Response $codigoGlosa
     * @author JDSS
     */

    public function guardar(CrearCodigoGlosasRequest $request){
        try {
           $codigoGlosa = $this->codigoGlosaRepository->crear($request->validated());
           return response()->json($codigoGlosa);
        } catch (\Throwable $th) {
            return response()->json(false);
        }
    }

     /**
     * actualiza el estado codigo de glosas
     * @param Request $id_codigo_glosa
     * @return Response $codigoGlosa
     * @author JDSS
     */

     public function cambiarEstado($id_codigo_glosa){
        try {
           $codigoGlosa = $this->codigoGlosaRepository->cambiarEstado($id_codigo_glosa);
           return response()->json($codigoGlosa);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
}
