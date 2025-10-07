<?php

namespace App\Http\Modules\Tutelas\Services;

use App\Http\Modules\ActuacionTutelas\Models\actuacionTutelas;
use App\Http\Modules\ActuacionTutelas\Repositories\ActuacionTutelaRepository;
use App\Http\Modules\ActuacionTutelas\Services\ActuacionTutelaService;
use App\Http\Modules\AfiliadoClasificaciones\Models\AfiliadoClasificacion;
use App\Http\Modules\AfiliadoClasificaciones\Repositories\AfiliadoClasificacionRepository;
use App\Http\Modules\Tutelas\Models\HistoricoCierreTutela;
use App\Http\Modules\Tutelas\Repositories\HistoricoCierreTutelaRepository;
use App\Http\Modules\Tutelas\Repositories\TutelaRepository;
use App\Http\Modules\valoracionAntropometrica\Model\ValoracionAntropometrica;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\UnaryPlus;
use PHPUnit\TextUI\Configuration\IniSettingCollection;
use Sabberworm\CSS\Value\CalcFunction;

class TutelaService {

    public function __construct(private TutelaRepository $tutelaRepository,
                                private HistoricoCierreTutelaRepository $historicoCierreTutelaRepository,
                                private ActuacionTutelaRepository $actuacionTutelaRepository,
                                private AfiliadoClasificacionRepository $afiliadoClasificacionRepository){}

    public function crear($data)
    {
        try {
            $tutela = $this->tutelaRepository->crear($data);

            //si la tutela se crea exitosamente se verifica si el usuario ya tiene clasificacion. En caso de no ternerla se crea
            if ($tutela === true) {
                $afiliado = [
                    "afiliado_id" => $data["afiliado_id"],
                    "clasificacion_id" => 10
                ];


                $clasificaciones = $this->afiliadoClasificacionRepository->listarAfiliacionClasificacion($data["afiliado_id"]);

                foreach ($clasificaciones as $cl) {
                    if ($cl['clasificacion']['id'] != 10) {
                        // dd($cl);
                        $this->afiliadoClasificacionRepository->crearClasificacion($afiliado);
                        return true;
                    }
                }
            }





            return $tutela;

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        

    }
    
    public function listar($data):LengthAwarePaginator
    {
        return $this->tutelaRepository->listar($data);
    }


    /**
     * Se cierra la tutela y las actuaciones que tenga la tutela a traves del respositorio. Posteriormente se verifica que que no tenga más procesos abiertos (sin asignar, asignados, cerrado temporal), y se ser este el caso, le elimina la marcación en el sistema.
     * @param mixed $data
     * @return HistoricoCierreTutela|string|\Illuminate\Database\Eloquent\Model
     */
    public function cerrarTutela($data){

        DB::beginTransaction();
        try {
            
            //cierro la tutela o accion constitucional
            $this->tutelaRepository->cerrarTutela($data->tutela_id);
            
            //cierro las actuaciones relacionadas con esa tutela o accion constitucional
            $this->actuacionTutelaRepository->cerrarActuacion($data->tutela_id);

            //listo y verifico si tiene tutelas o acciones constitucionales en estado 'abierto' (sin asignar, asignadas, cerradas temporal). Si queda en 0, entonces le actualizo la clasificacion para que no le marque tutelas
            $tutelaAbierta = $this->tutelaRepository->listarTutelasAbiertas($data['afiliado_id']);
            if (count($tutelaAbierta) == 0) {
                AfiliadoClasificacion::where('afiliado_id', $data['afiliado_id'])->where('clasificacion_id', 10)->delete();
                
            }
            DB::commit();
            //finalmente actualizo el historico de cierres
            return $this->historicoCierreTutelaRepository->crearCierre($data);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    /**
     * Permite cerrar de manera temporal un tutela(accion constitucional) de acuerdo con los datos recibidos que incluyen el motivo, el id de la tutela, id del usuario que cierra y el tipo de cierre. Entonces actualiza en la table de tutela y de actuacion.
     * @param mixed $data
     * @return mixed $data
     * @author AlejoSR
     */
    public function cerrarTutelaTemporal($data)
    {
        try {
            $cierre_tutela = $this->tutelaRepository->cerrarTutelaTemporal($data->tutela_id);
            $cierre_actuacion = $this->actuacionTutelaRepository->cerrarActuacionTemporal($data->tutela_id);

            if ($cierre_actuacion && $cierre_tutela == true) {
                return $this->historicoCierreTutelaRepository->crearCierreTemporal($data);
            }


        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
        
    }

    public function actualizarTutela($data){
        return $this->tutelaRepository->actualizarEstadoAsignado($data);
    }
     

    /**
     * Reabrir accion constitucional o tutela segun el ID que ingrese en la data.
     * @param $data -> objeto con informacion de una acción constitucional que contenga id_tutela
     * @return bool|string
     */
    public function abrirTutela($data){
        try {
            $tutelaRespuesta = $this->tutelaRepository->abrirTutela($data);
            if (!$tutelaRespuesta) {

                return false;
            }

            #listo las tutelas por el id de la tutela
            $tutelas = $this->tutelaRepository->listarTutelas($data['tutela_id']);

            # obtengo el id del afiliado relacionado en la tutela para crearle la clasificación 10 que es tutela
            $data = [
                "afiliado_id" => $tutelas["afiliado_id"],
                "clasificacion_id" => 10
            ];
            #creo la clasificacion
            $this->afiliadoClasificacionRepository->crearClasificacion($data);


            return true;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function listarPorId($id){
        return $this->tutelaRepository->listarTutelas(id_tutela: $id);
    }

}
