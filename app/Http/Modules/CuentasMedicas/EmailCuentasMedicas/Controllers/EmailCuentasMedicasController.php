<?php

namespace App\Http\Modules\CuentasMedicas\EmailCuentasMedicas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\CuentasMedicas\Glosas\Repositories\GlosaRepository;
use App\Http\Modules\CuentasMedicas\Facturas\Repositories\FacturaRepository;
use App\Http\Modules\CuentasMedicas\EmailCuentasMedicas\Requests\CrearEmailCuentasMedicasRequest;
use App\Http\Modules\CuentasMedicas\EmailCuentasMedicas\Repositories\EmailCuentasMedicaRepository;

class EmailCuentasMedicasController extends Controller
{

    public function __construct(private EmailCuentasMedicaRepository $emailCuentasMedicaRepository, private GlosaRepository $glosaRepository,private FacturaRepository $facturaRepository) {

    }

    /**
     * listar los email de los prestadores
     * @param Request $request
     * @return Response $email
     * @author JDSS
     */
    public function listar(Request $request){
        try {
            $email = $this->emailCuentasMedicaRepository->listarEmail($request);
            return response()->json($email,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * crea los email
     * @param Request $request
     * @return Response $email
     * @author JDSS
     */

     public function crear(CrearEmailCuentasMedicasRequest $request){
        try {
            $email = $this->emailCuentasMedicaRepository->crear($request->validated());
            return response()->json($email);
        } catch (\Throwable $th) {
           return response()->json($th->getMessage());
        }
     }

     /**
     * actualiza el email
     * @param Request $id_email_prestador, $request
     * @return Response $codigoGlosa
     * @author JDSS
     */

     public function cambiarEmail($id_email_prestador, Request $request){
        try {
           $codigoGlosa = $this->emailCuentasMedicaRepository->cambiarEmail($id_email_prestador, $request->email);
           return response()->json($codigoGlosa);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    /**
     * notifica a los prestadores por correo electronico para decirles que tienen asignada una factura
     * @return Response $emailPrestador
     * @author JDSS
     */
    public function notificar(Request $request){

        try {
            $emailPrestador = $this->emailCuentasMedicaRepository->crearActualizar($request);
        if($emailPrestador){
            $afAuditadas = $this->facturaRepository->afAuditadas($request->prestador);
            $afs_conglosa_id = $this->glosaRepository->afGlosa($afAuditadas,$emailPrestador);
            return response()->json(['mensaje'=>$afs_conglosa_id],Response::HTTP_OK);
        }else{
            return response()->json(['mensaje'=>'El prestador no tiene un email parametrizado!'],Response::HTTP_BAD_REQUEST);
        }
        } catch (\Throwable $th) {
            return response()->json(['mensaje'=>'ERROR'],Response::HTTP_BAD_REQUEST);
        }

    }

}
