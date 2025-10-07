<?php

namespace App\Http\Modules\CuentasMedicas\AdjuntoRelacionPago\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\CuentasMedicas\AdjuntoRelacionPago\Repositories\AdjuntoRelacionPagoRepository;
use App\Http\Modules\CuentasMedicas\AdjuntoRelacionPago\Requests\AdjuntoRelacionPagoRequest;
use App\Http\Modules\CuentasMedicas\AdjuntoRelacionPago\Requests\CrearAdjuntoRelacionPagoRequest;
use App\Http\Modules\CuentasMedicas\AdjuntoRelacionPago\Services\AdjuntoRelacionPagoServices;

class AdjuntoRelacionPagoController extends Controller
{
    public function __construct(private AdjuntoRelacionPagoRepository $adjuntoRelacionPagoRepository,
                                private AdjuntoRelacionPagoServices $adjuntoRelacionPagoServices) {

    }

    /**
     * Busca los adjuntos de la carga de pagos
     * @return Response $adjuntosRelacionPago
     * @author JDSS
     */

     public function buscarCargaPagos(AdjuntoRelacionPagoRequest $request){
        try {
            $relacionPagos = $this->adjuntoRelacionPagoRepository->buscarCargaPagos($request->validated());
            return response()->json($relacionPagos,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>$th->getMessage()],Response::HTTP_BAD_REQUEST);
        }
     }

     /**
     * guarda los adjuntos de la carga de pagos
     * @return Response $adjuntosRelacionPago
     * @author JDSS
     */

     public function guardarCargaPagos(CrearAdjuntoRelacionPagoRequest $request){
        try {
            $relacionPagos = $this->adjuntoRelacionPagoServices->crearAdjuntoRelacionPago($request->validated());
            return response()->json($relacionPagos,Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>'Error al crear'],Response::HTTP_BAD_REQUEST);
        }
     }


     /**
     * Busca los adjuntos de la carga de pagos
     * @return Response $adjuntosRelacionPago
     * @author JDSS
     */

     public function buscarPagosPrestador(Request $request){
        try {
            $relacionPagos = $this->adjuntoRelacionPagoRepository->buscarPagosPrestador($request->all());
            return response()->json($relacionPagos,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>$th->getMessage()],Response::HTTP_BAD_REQUEST);
        }
     }

     public function eliminar(int $id)
     {
         try {
             $teleapoyo = $this->adjuntoRelacionPagoRepository->eliminar($id);
             return response()->json([$teleapoyo,
             'mensaje' => 'Eliminado con exito!'], Response::HTTP_ACCEPTED);
         } catch (\Throwable $th) {
             return response()->json(['mensaje' => 'Error al eliminar!',
             'error' =>$th->getMessage()], Response::HTTP_BAD_REQUEST);
         }
     }

     public function estadoCuenta(Request $request){
        try {
            $evento = $this->adjuntoRelacionPagoRepository->estadoCuenta($request->all());
            return $evento;
           } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar la información.',
                'error' => $th->getMessage()
            ],Response::HTTP_BAD_REQUEST);
           }
     }


}
