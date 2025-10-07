<?php

namespace App\Http\Modules\ContratosEmpleados\Services;

use App\Http\Modules\CierreMesContratosEmpleados\Repositories\CierreMesContratoEmpleadoRepository;
use App\Traits\ArchivosTrait;
use App\Http\Modules\ContratosEmpleados\Repositories\ContratoEmpleadoRepository;
use App\Http\Modules\Empleados\Repositories\EmpleadoRepository;
use Carbon\Carbon;

class ContratoEmpleadoService {

        use ArchivosTrait;

        public function __construct(protected ContratoEmpleadoRepository $contratoEmpleadoRepository, private EmpleadoRepository $empleadoRepository,
                                    protected CierreMesContratoEmpleadoRepository $cierreMesEmpleadoRepository){

        }

        public function guardarContratoEmpleado($request) {
            $ruta_011= '\talento_humano\contrato_empleado';
            $archivo = $request->file('adjunto');
            $ruta_archivo = $this->subirArchivo($ruta_011,$archivo,'server37');
            $nombre_archivo = explode('/',$ruta_archivo);
            // $ejecutarProcedimiento = (DB::select('exec dbo.sp_NovedadesDiariasUsFomag ?', [$nombre_archivo[1]]));
            $eliminar_archivo = $this->borrarArchivo($ruta_archivo,'server37');
            return $eliminar_archivo;
        }

        public function terminar($contrato){

         $this->contratoEmpleadoRepository->terminar($contrato->id);

        //  return $this->empleadoRepository->inactivar($contrato->empleado_id);


        }
        // $empleado = $this->empleadoRepository->buscarEmpleado($id->empleado_id);

        public function cierreMes($contratoEmpleado, $request){
            $fecha_cierre = Carbon::parse($request);
            $ultimo_dia = $fecha_cierre->lastOfMonth();
            foreach($contratoEmpleado as $key){
              $this->cierreMesEmpleadoRepository->crearCierreMes($key,$ultimo_dia);
            }

        }
    }
