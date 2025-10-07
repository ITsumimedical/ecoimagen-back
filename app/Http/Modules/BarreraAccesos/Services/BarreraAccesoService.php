<?php

namespace App\Http\Modules\BarreraAccesos\Services;

use App\Traits\ArchivosTrait;
use App\Http\Modules\BarreraAccesos\Models\ResponsableBarreraAcceso;
use App\Http\Modules\BarreraAccesos\Repositories\AdjuntoBarreraAccesoRepository;
use App\Http\Modules\BarreraAccesos\Repositories\BarreraAccesoRepository;
use App\Http\Modules\BarreraAccesos\Repositories\ResponsableRepository;
use App\Mail\BarrerasAccesoGestionMail;
use App\Mail\BarrerasAccesoMail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BarreraAccesoService
{
    use ArchivosTrait;

    public function __construct(protected BarreraAccesoRepository $barreraAccesoRepository, protected ResponsableRepository $responsableRepository, protected AdjuntoBarreraAccesoRepository $adjuntoBarreraAccesoRepository) {}

    /**
     * Crear barrera y subir archivos adjuntados
     * @author Sofia O
     */
    public function crearBarrera(array $data)
    {
        DB::beginTransaction();
        try {
            $barrera = $this->barreraAccesoRepository->crearBarrera($data);

            if (isset($data['adjuntos']) && sizeof($data['adjuntos']) >= 1) {
                $archivos = $data['adjuntos'];
                $ruta = 'adjuntosBarreraAcceso';
                foreach ($archivos as $archivo) {
                    $nombreOriginal = $archivo->getClientOriginalName();
                    $nombre = $barrera['id'] . '/' . time() . $nombreOriginal;
                    $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
                    $this->adjuntoBarreraAccesoRepository->crearAdjunto($barrera['id'], $nombreOriginal, $subirArchivo);
                }
            }

            Mail::to('luis.luna@sumimedical.com')->send(new BarrerasAccesoMail($barrera['id'], $barrera['barrera'], $barrera['observacion']));

            DB::commit();
            return $barrera;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Funcion para dar Solucion, Dar respuesta, Corregir y Anular
     * @author Sofia O
     */
    public function solucionar(array $data, int $id)
    {
        $barrera = $this->barreraAccesoRepository->buscarBarreraAcceso($id);
        $actualizar = $this->barreraAccesoRepository->actualizarBarrera($data, $barrera);

        if ($data['estado_id'] == 18) {
            $mensaje = 'Le informamos que uno de los responsables asignado la siguiente barrera de acceso ha dado respuesta:';
            $this->envioCorreoGestion($mensaje, 'luis.luna@sumimedical.com', $barrera);
        } else if ($data['estado_id'] == 17) {
            $mensaje = 'Le informamos que se le ha solucionado la siguiente barrera de acceso que usted había reportado:';
            $this->envioCorreoGestion($mensaje, $barrera['userCrea']['email'], $barrera);
        } else if ($data['estado_id'] == 5) {
            $mensaje = 'Le informamos que se le ha anulado la siguiente barrera de acceso que usted había reportado:';
            $this->envioCorreoGestion($mensaje, $barrera['userCrea']['email'], $barrera);
        }

        return $actualizar;
    }

    /**
     * Actualizar barrera de acceso
     * @author Sofia O
     */
    public function actualizarBarrera(array $data, int $id)
    {
        $barrera = $this->barreraAccesoRepository->buscarBarreraAcceso($id);
        return $this->barreraAccesoRepository->actualizarBarrera($data, $barrera);
    }

    /**
     * Asignar responsables
     * @author Sofia O
     */
    public function asignar(array $data)
    {
        DB::beginTransaction();
        try {
            $barrera = $this->barreraAccesoRepository->buscarBarreraAcceso($data['id']);
            $this->barreraAccesoRepository->actualizarBarrera(['estado_id' => $data['estado_id']], $barrera);

            if ($barrera && isset($data['area'])) {
                $barrera->responsables()->syncWithoutDetaching($data['area']);
            }

            $responsables = $this->responsableRepository->buscarResponsablesBarrera($data['id']);
            $correo_responsble = $responsables->pluck('correo')->toArray();

            $mensaje = 'Le informamos que se le ha asignado la siguiente barrera de acceso:';

            $this->envioCorreoGestion($mensaje, $correo_responsble, $barrera);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Reasignar reponsables
     * @author Sofia O
     */
    public function reasignar(array $data)
    {
        DB::beginTransaction();
        try {
            $barrera = $this->barreraAccesoRepository->buscarBarreraAcceso($data['id']);

            $datosSinResponsables = Arr::except($data, ['area']);
            $barrera->fill($datosSinResponsables);
            $this->barreraAccesoRepository->guardar($barrera);

            if (!empty($data['area'])) {
                $barrera->responsables()->sync($data['area']);
            }

            $responsables = $this->responsableRepository->buscarResponsablesBarrera($data['id']);
            $correo_responsble = $responsables->pluck('correo')->toArray();

            $mensaje = 'Le informamos que se le ha reasignado la siguiente barrera de acceso. Le solicitamos revisar la información correspondiente:';

            $this->envioCorreoGestion($mensaje, $correo_responsble, $barrera);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Listar las solicitudes gestionadas y anuladas. Con su semaforo de dias trancurridos
     * @author Sofia O
     */
    public function listarSolucionadasAnuladas(array $data)
    {
        $resultado = $this->barreraAccesoRepository->listarSolucionadasAnuladas($data);
        return $this->calcularDiasTranscurridos($resultado);
    }

    /**
     * Listar las solicitudes gestionadas y anuladas del user logueado. Con su semaforo de dias trancurridos
     * @author Sofia O
     */
    public function listarSolucionadasAnuladasUser(array $data)
    {
        $resultado = $this->barreraAccesoRepository->listarSolucionadasAnuladasUser($data);
        return $this->calcularDiasTranscurridos($resultado);
    }

    /**
     * Listar las barreras registrada por el user. Con su semaforo de dias trancurridos
     * @author Sofia O
     */
    public function listarRegistradasUser(array $data)
    {
        $resultado = $this->barreraAccesoRepository->listarBarrerasUser($data);
        return $this->calcularDiasTranscurridos($resultado);
    }

    /* Semaforo para calcular los dias trancurridos
     * @author Sofia O
     */
    private function calcularDiasTranscurridos($resultado)
    {
        foreach ($resultado as $resultadosItem) {
            $fechaCreacion = Carbon::parse($resultadosItem->created_at);
            $fechaActual = Carbon::now();

            $diasTranscurridos = $fechaCreacion->diffInDays($fechaActual);

            $resultadosItem->diasTranscurridos = $diasTranscurridos;

            if ($diasTranscurridos <= 30) {
                $resultadosItem->color = 'green';
            } else if ($diasTranscurridos > 30 && $diasTranscurridos <= 40) {
                $resultadosItem->color = 'orange';
            } else {
                $resultadosItem->color = 'red';
            }
        }

        return $resultado;
    }

    /**
     * Envio de correo reutilizable para la gestion de las barreras
     * @author Sofia O
     */
    private function envioCorreoGestion($mensaje, $correo_responsble, $barrera)
    {
        Mail::to($correo_responsble)->send(new BarrerasAccesoGestionMail($mensaje, $barrera['id'], $barrera['barrera'], $barrera['observacion'], $barrera['observacion_cierre'], $barrera['observacion_solucion']));
    }
}
