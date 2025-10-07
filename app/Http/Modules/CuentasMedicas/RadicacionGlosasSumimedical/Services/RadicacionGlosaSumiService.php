<?php

namespace App\Http\Modules\CuentasMedicas\RadicacionGlosasSumimedical\Services;

use App\Http\Modules\CuentasMedicas\ActasCuentasMedicas\Repositories\ActasCuentasMedicasRepository;
use App\Http\Modules\CuentasMedicas\Facturas\Repositories\FacturaRepository;
use App\Http\Modules\CuentasMedicas\Glosas\Repositories\GlosaRepository;
use App\Http\Modules\CuentasMedicas\RadicacionGlosasSumimedical\Repositories\RadicacionGlosasSumimedicalRepository;
use Illuminate\Support\Facades\Auth;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Traits\ArchivosTrait;

class RadicacionGlosaSumiService {

    use ArchivosTrait;

    public function __construct(private RadicacionGlosasSumimedicalRepository $radicacionGlosaSumiRepository,
                                private GlosaRepository $glosaRepository,
                                private FacturaRepository $facturaRepository,
                                private ActasCuentasMedicasRepository $actasCuentasMedicasRepository){

    }

    public function validacionExcel($data){
        $existe = [];
        $msg = [];


        (new FastExcel)->import($data['excel'],function($line)use(&$existe,&$msg,&$data){

            if( strlen($line["GLOSA_ID"]) <= 0 || strlen($line["ACEPTA_IPS"]) <= 0 || strlen($line["LEVANTA_SUMI"]) <= 0
            || strlen($line["NO_ACUERDO"]) <= 0 ){

                $msg = 'Hay campos obligatorios vacios, revisa: ( glosa_id, acepta_ips, levanta_sumi, no_acuerdo )';

            }else if($line["NIT"] != $data['nit_prestador']){

                $msg = 'Esta intentando cargar un Excel con un Nit diferente al seleccionado '. $data['nit_prestador'];

            }else {

                $excel["glosa_id"] = $line["GLOSA_ID"];
                $excel["acepta_ips"] = $line["ACEPTA_IPS"];
                $excel["levanta_sumi"] = $line["LEVANTA_SUMI"];
                $excel["no_acuerdo"] = $line["NO_ACUERDO"];
                $existe[] = $excel;

            }
        });

        if($msg ){

            return $msg;

        }else{
            $afs_id = [];
            foreach($existe as $e){
              $this->radicacionGlosaSumiRepository->actualizarGlosa($e);
              $this->radicacionGlosaSumiRepository->actualizarEstado($e);
              $glosa = $this->glosaRepository->seleccionarGlosa($e['glosa_id']);
              $afs_id[] = $glosa->af_id;
            }

            $afs = array_unique($afs_id);

            foreach($afs as $af){
                $contadorGlosas = $this->glosaRepository->contadorTotalGlosas($af);
                $contadorGlosasEstado = $this->glosaRepository->contadorGlosasasRadicadasEStado2($af);
                $contadorGlosas == $contadorGlosasEstado ? $this->facturaRepository->actualizarTerminado($af):$this->facturaRepository->actualizarTemporal($af);
            }

            if($data['adjunto']){

                $archivo = $data['adjunto'];
                $ruta = 'actasCuentasMedicas';
                $nombreOriginal = $archivo->getClientOriginalName();
                $nombre = $data['prestador_id'] .'/'.time().$nombreOriginal;
                $subirArchivo = $this->subirArchivoNombre($ruta,$archivo,$nombre,'server37');
                $prepararData= $this->prepararData($data['prestador_id'],$nombreOriginal,$subirArchivo);
                $this->actasCuentasMedicasRepository->crear($prepararData);
            }

            return 'Conciliacion guardada con exito!';


        }
    }

    public function prepararData($prestador,$nombreArchivo,$ruta){

        $acta['prestador_id'] = $prestador;
        $acta['user_id'] = Auth()->user()->id;
        $acta['nombre'] =$nombreArchivo;
        $acta['ruta'] = $ruta;

        return $acta;
    }

    public function validacionExcelAdministrativo($data){
        $existe = [];
        $msg = [];


        (new FastExcel)->import($data['excel'],function($line)use(&$existe,&$msg,&$data){

            if( strlen($line["GLOSA_ID"]) <= 0 || strlen($line["ACEPTA_IPS"]) <= 0 || strlen($line["LEVANTA_SUMI"]) <= 0
            || strlen($line["NO_ACUERDO"]) <= 0 ){

                $msg = 'Hay campos obligatorios vacios, revisa: ( glosa_id, acepta_ips, levanta_sumi, no_acuerdo )';

            }else if($line["NIT"] != $data['nit_prestador']){

                $msg = 'Esta intentando cargar un Excel con un Nit diferente al seleccionado '. $data['nit_prestador'];

            }else {

                $excel["glosa_id"] = $line["GLOSA_ID"];
                $excel["acepta_ips"] = $line["ACEPTA_IPS"];
                $excel["levanta_sumi"] = $line["LEVANTA_SUMI"];
                $excel["no_acuerdo"] = $line["NO_ACUERDO"];
                $excel["glosa_inicial"] = $line["GLOSA_INICIAL"];
                $existe[] = $excel;

            }
        });

        if($msg ){

            return $msg;

        }else{
            $afs_id = [];
            foreach($existe as $e){
             $this->radicacionGlosaSumiRepository->actualizarGlosaAdministrativa($e);
             $this->radicacionGlosaSumiRepository->actualizarEstado($e);
              $glosa = $this->glosaRepository->seleccionarGlosa($e['glosa_id']);
              $afs_id[] = $glosa->af_id;
            }

            $afs = array_unique($afs_id);

            foreach($afs as $af){
            $this->facturaRepository->actualizarTerminado($af);
            }

            return 'Conciliacion guardada con exito!';




        }

    }

    public function validacionExcelConSaldo($data){
        $existe = [];
        $msg = [];


        (new FastExcel)->import($data['excel'],function($line)use(&$existe,&$msg,&$data){

            if( strlen($line["GLOSA_ID"]) <= 0 || strlen($line["ACEPTA_IPS_2"]) <= 0 || strlen($line["LEVANTA_SUMI"]) <= 0
            || strlen($line["NO_ACUERDO"]) <= 0 ){

                $msg = 'Hay campos obligatorios vacios, revisa: ( glosa_id, ips_acepta_2, levanta_sumi, no_acuerdo )';

            }else if($line["NIT"] != $data['nit_prestador']){

                $msg = 'Esta intentando cargar un Excel con un Nit diferente al seleccionado '. $data['nit_prestador'];

            }else {

                $excel["glosa_id"] = $line["GLOSA_ID"];
                $excel["acepta_ips"] = $line["ACEPTA_IPS_2"];
                $excel["levanta_sumi"] = $line["LEVANTA_SUMI"];
                $excel["no_acuerdo"] = $line["NO_ACUERDO"];
                $existe[] = $excel;

            }
        });

        if($msg ){

            return $msg;

        }else{
            $afs_id = [];
            foreach($existe as $e){
              $this->radicacionGlosaSumiRepository->actualizarGlosaConSaldo($e);
              $this->radicacionGlosaSumiRepository->actualizarEstado($e);
              $glosa = $this->glosaRepository->seleccionarGlosa($e['glosa_id']);
              $afs_id[] = $glosa->af_id;
            }

            $afs = array_unique($afs_id);

            foreach($afs as $af){
                $contadorGlosas = $this->glosaRepository->contadorTotalGlosas($af);
                $contadorGlosasEstado = $this->glosaRepository->contadorGlosasasRadicadasEStado2($af);
                $contadorGlosas == $contadorGlosasEstado ? $this->facturaRepository->actualizarTerminado($af):$this->facturaRepository->actualizarTemporal($af);
            }

            if($data['adjunto']){

                $archivo = $data['adjunto'];
                $ruta = 'actasCuentasMedicas';
                $nombreOriginal = $archivo->getClientOriginalName();
                $nombre = $data['prestador_id'] .'/'.time().$nombreOriginal;
                $subirArchivo = $this->subirArchivoNombre($ruta,$archivo,$nombre,'server37');
                $prepararData= $this->prepararData($data['prestador_id'],$nombreOriginal,$subirArchivo);
                $this->actasCuentasMedicasRepository->crear($prepararData);
            }

            return 'Conciliacion guardada con exito!';


        }
    }


}
