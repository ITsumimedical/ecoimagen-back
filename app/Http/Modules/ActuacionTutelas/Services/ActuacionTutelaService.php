<?php

namespace App\Http\Modules\ActuacionTutelas\Services;


use App\Http\Modules\ActuacionTutelas\Repositories\ActuacionTutelaRepository;
use App\Http\Modules\ResponsableTutela\Repositories\ResponsableTutelaRespository;
use App\Http\Modules\Tutelas\Services\TutelaService;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Traits\ArchivosTrait;
use Error;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Facades\Mail;

class ActuacionTutelaService
{

    use ArchivosTrait;

    public function __construct(
        private ActuacionTutelaRepository $actuacionTutelaRepository,
        private TutelaService $tutelaService,
        private ResponsableTutelaRespository $responsableTutelaRespository

    ) {}

    public function prepararData($data)
    {
        $data['quien_creo_id'] = Auth::id();
        return $data;
    }

    /**
     * Creo una actuación de una tutela y si el resultado de la creación es exitoso, entonces reabro la tutela general para que el estado quede como no asignado y quede a la espera para su respectiva asignación.
     * @param mixed $datos
     * @return bool|string
     * @author AlejoSR
     */
    public function crearActuacionTutela($datos): bool|string
    {
        $actuacion =  $this->actuacionTutelaRepository->crearActuacionTutela($datos);
        if ($actuacion === true) {
            return $this->tutelaService->abrirTutela($datos);
        }
        return $actuacion;
    }

    /**
     * Asigno responsable y realizo envío de las notificaciones al o los responsables luego de asginar la tutela.
     * @param mixed $data
     * @return 
     */
    public function asignar($data)
    {
        #verifico que si traiga procesos para asignar, de lo contrario regreso un error
        if (count($data['proceso_tutela_id']) == 0) {
            throw new Exception('La asignación de responsable requiere un proceso');
        }

        DB::beginTransaction();
        try {

            #si viene con al menos un proceso, asigno la actuación
            $actuacion = $this->actuacionTutelaRepository->asignarActuacion($data);


            #uso el servicio de tutelas para actualizar el estado en la tabla tutelas a 6 que es asignado.
            $this->tutelaService->actualizarTutela($actuacion->tutela_id);

            #listo la tutela relacionada para obtener el numero de radicado
            $tutela = $this->tutelaService->listarPorId($actuacion->tutela_id);

            #listo la actuacion incluyendo el tipo de actuación para el envio de la notificacion en el correo
            $actuacion = $this->actuacionTutelaRepository->listarPorId($data['actuacion_tutelas_id'])->first();


            #confirmo la información que será enviada a través de correo
            $nombreActuacion = $actuacion->tipoActuacion->nombre;
            $radicadoTutela = $tutela->radicado;
            $observacion = $actuacion->observacion;


            $datos = [
                'nombreActuacion' => $nombreActuacion,
                'radicadoTutela' => $radicadoTutela,
                'observacion' => $observacion
            ];



            #Realizo la notificacion al responsable del proceso asignado
            foreach ($data['proceso_tutela_id'] as $proceso_id) {
                $correo = $this->responsableTutelaRespository->obtenerCorreo($proceso_id);
                $asunto = 'Notificación asignación de proceso constitucional';

                // dd($correo);
                Mail::send('email_asignacion_tutela', $datos, function ($mensaje) use ($correo, $asunto) {
                    $mensaje->to($correo)
                        ->subject($asunto);
                });
            }


            DB::commit();
            return $actuacion;
        } catch (Throwable $th) {
            // DB::rollBack();
            return $th->getMessage();
        }
    }

    public function cerrarActuacionTemporal($data)
    {
        return $this->actuacionTutelaRepository->cerrarActuacionTemporal($data);
    }
    
    // public function abrirActuacion($data)
    // {

    //     try {
    //         $actuacionRespuesta = $this->actuacionTutelaRepository->abrirActuacion($data);

    //         if ($actuacionRespuesta === true) {
    //             return true;
    //         }

    //         throw new \Error('Actuación no encontrada');
    //     } catch (\Throwable $th) {
    //         return $th->getMessage();
    //     }
    // }

    public function listarCerradaTemporal($data)
    {
        try {
            $actuacion = $this->actuacionTutelaRepository->listarCerradaTemporal($data);
            if ($actuacion) {
                return $actuacion;
            }
            throw new \Error('Error al listar las actuaciones');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function listarActuacion($data, $id)
    {
        return $this->actuacionTutelaRepository->listarActuaciones($data, $id);
    }

    public function listarAsignada($data)
    {
        return $this->actuacionTutelaRepository->listarAsignada($data);
    }

    public function listarAsignadaCerrada($data)
    {
        return $this->actuacionTutelaRepository->listarAsignadaCerrada($data);
    }
}
