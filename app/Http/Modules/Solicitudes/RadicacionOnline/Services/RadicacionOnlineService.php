<?php

namespace App\Http\Modules\Solicitudes\RadicacionOnline\Services;

use App\Http\Modules\Afiliados\Models\BeneficiarioRadicacion;
use App\Http\Modules\Afiliados\Repositories\AfiliadoRepository;
use App\Http\Modules\Empleados\Repositories\EmpleadoRepository;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Solicitudes\AdjuntosRadicacionOnline\Repositories\AdjuntosRadicacionOnlineRepository;
use App\Http\Modules\Solicitudes\GestionRadicacionOnline\Repositories\GestionRadicacionOnlineRepository;
use App\Http\Modules\Solicitudes\RadicacionOnline\Repositories\RadicacionOnlineRepository;
use App\Http\Modules\Solicitudes\TipoSolicitud\Repositories\TipoSolicitudRedVitalRepository;
use App\Http\Modules\Solicitudes\TipoSolicitudEmpleado\Repositories\TipoSolicitudEmpleadoRepository;
use App\Http\Modules\Tipos\Repositories\TipoRepository;
use Illuminate\Support\Facades\Auth;
use App\Traits\ArchivosTrait;
use Illuminate\Support\Facades\Mail;

class RadicacionOnlineService
{
    use ArchivosTrait;

    public function __construct(
        private RadicacionOnlineRepository $radicacionOnlineRepository,
        private GestionRadicacionOnlineRepository $gestionRadicacionOnlineRepository,
        private TipoSolicitudRedVitalRepository $tipoSolicitudRedVitalRepository,
        private AfiliadoRepository $afiliadoRepository,
        private TipoSolicitudEmpleadoRepository $tipoSolicitudEmpleadoRepository,
        private AdjuntosRadicacionOnlineRepository $adjuntosRadicacionOnlineRepository,
        private TipoRepository $tipoRepository,
        private EmpleadoRepository $empleadoRepository
    ) {
    }


    public function radicacion($request)
    {
        $radicado =  $this->radicacionOnlineRepository->crearRadicacion($request);
        if (isset(Auth::user()->id)) {
            $this->gestionRadicacionOnlineRepository->crearGestion($radicado->id, Auth::user()->id, 3, 'Creo Radicado', null);
        }
        $opcionSolicitud = $this->tipoSolicitudRedVitalRepository->obtnerTipoPorId($request['solicitud_id']);
        $afiliado = $this->afiliadoRepository->obtenerDatosAfiliadoPorIdCompleto($request['afiliado_id']);
        $afiliado->update(['celular1' => $request['telefono'], 'correo1' => $request['correo']]);

        $archivos = $request['adjuntos'];
        $ruta = 'pruebaAdjuntos';
        if (sizeof($archivos) >= 1) {
            foreach ($archivos as $archivo) {
                $nombreOriginal = $archivo->getClientOriginalName();
                $nombre = $request['documento'] . '/' . time() . '_' . 'adjunto' . '_' . $nombreOriginal;
                $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
                $this->adjuntosRadicacionOnlineRepository->crearAdjunto($nombre, $subirArchivo, $radicado->id);
            }
        }

        $data = [];
        $data['radicado'] = $radicado->id;
        $data['solicitud_id'] = $request['solicitud_id'];

        if ($request['solicitud_id'] == 26) {
            $beneficiario = new BeneficiarioRadicacion();
            $beneficiario->tipo_documento_id = $request['tipo_documento'];
            $beneficiario->numero_documento = $request['numero_documento'];
            $beneficiario->primer_nombre = $request['primer_nombre'];
            $beneficiario->segundo_nombre = $request['segundo_nombre'];
            $beneficiario->primer_apellido = $request['primer_apellido'];
            $beneficiario->segundo_apellido = $request['segundo_apellido'];
            $beneficiario->sexo = $request['sexo'];
            $beneficiario->fecha_nacimiento = $request['fecha_nacimiento'];
            $beneficiario->parentesco = $request['parentesco'];
            $beneficiario->discapacidad = $request['discapacidad'];
            if (isset($request['grado_discapacidad'])) {
                $beneficiario->grado_discapacidad = $request['grado_discapacidad'];
            }
            $beneficiario->pais_id = $request['pais_id'];
            $beneficiario->departamento_afiliacion_id = $request['departamento_id'];
            $beneficiario->departamento_atencion_id = $request['departamento_id'];
            $beneficiario->municipio_afiliacion_id = $request['municipio_id'];
            $beneficiario->municipio_atencion_id = $request['municipio_id'];
            $beneficiario->direccion_residencia_cargue = $request['direccion_residencia_cargue'];
            $beneficiario->direccion_residencia_numero_exterior = $request['direccion_residencia_numero_exterior'];
            $beneficiario->direccion_residencia_primer_interior = $request['direccion_residencia_primer_interior'];
            $beneficiario->direccion_residencia_segundo_interior = $request['direccion_residencia_segundo_interior'];
            $beneficiario->direccion_residencia_interior = $request['direccion_residencia_interior'];
            $beneficiario->direccion_residencia_barrio = $request['direccion_residencia_barrio'];
            $beneficiario->telefono = $request['telefono'];
            $beneficiario->celular1 = $request['celular1'];
            $beneficiario->celular2 = $request['celular2'];
            $beneficiario->correo1 = $request['correo1'];
            $beneficiario->correo2 = $request['correo2'];
            $beneficiario->tipo_afiliado_id = 1;
            $beneficiario->tipo_afiliacion_id = 3;
            $beneficiario->entidad_id = 1;
            $beneficiario->numero_documento_cotizante = $afiliado->numero_documento;
            $beneficiario->solicitud_id = $radicado->id;
            $beneficiario->tipo_beneficiario_id = $request['tipo_beneficiario'];
            $beneficiario->save();
        }

        $afiliado = $this->radicacionOnlineRepository->datosparaEmail($data['radicado']);
        Mail::send('alerta_radicacion_email', ['radicado_id' => $data['radicado'], 'tipo' => 'Crear', 'name' => $afiliado->primer_nombre], function ($m) use ($afiliado) {
            $m->to($afiliado->correo1, $afiliado->primer_nombre)->subject('Notificación Radicación');
        });

        return $data;
    }

    public function comentar($request)
    {

        if ($request['gestionando'] == 'true') {
            $this->radicacionOnlineRepository->actualizarEstado($request['radicacion_online_id']);
        }
        $tipo = $this->tipoRepository->buscarNombre($request['accion']);
        $gestion = $this->gestionRadicacionOnlineRepository->crearGestion($request['radicacion_online_id'], Auth::user()->id, $tipo->id, $request['motivo'], null);

        if ($request['adjuntos'] != 'null') {

            $archivos = $request['adjuntos'];
            $ruta = 'adjuntosRadicacion';
            $user = Auth()->user()->id;
            $operador = Operadore::where('user_id', $user)->first();
            if (sizeof($archivos) >= 1) {
                foreach ($archivos as $archivo) {
                    $nombreOriginal = $archivo->getClientOriginalName();
                    $nombre = $operador->documento . '/' . $request['radicacion_online_id'] . '/' . time() . '_' . $nombreOriginal;
                    $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
                    $this->adjuntosRadicacionOnlineRepository->crearAdjuntoGestion($nombre, $subirArchivo, $gestion['id']);
                }
            }
        }

        if ($request['accion'] == 'Comentarios al Solicitante') {
            $afiliado = $this->radicacionOnlineRepository->datosparaEmail($request['radicacion_online_id']);
            if ($afiliado->correo1 != null) {
                Mail::send('alerta_radicacion_email', ['radicado_id' => $request['radicacion_online_id'], 'tipo' => 'Comentarios al Solicitante', 'name' => $afiliado->primer_nombre], function ($m) use ($afiliado) {
                    $m->to($afiliado->correo1, $afiliado->primer_nombre)->subject('Notificación Radicación');
                });
            }
        }

        return '¡Ha comentado la solicitud con exito!';
    }

    public function responder($request)
    {

        $this->radicacionOnlineRepository->actualizarEstadoCerrado($request['radicacion_online_id']);

        $gestion = $this->gestionRadicacionOnlineRepository->crearGestion($request['radicacion_online_id'], Auth::user()->id, 21, $request['motivo'], null);

        if ($request['adjuntos'] != 'null') {

            $archivos = $request['adjuntos'];
            $ruta = 'adjuntosRadicacion';
            $user = Auth()->user()->id;
            $operador = Operadore::where('user_id', $user)->first();
            if (sizeof($archivos) >= 1) {
                foreach ($archivos as $archivo) {
                    $nombreOriginal = $archivo->getClientOriginalName();
                    $nombre = $operador->documento . '/' . $request['radicacion_online_id'] . '/' . time() . '_' . $nombreOriginal;
                    $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
                    $this->adjuntosRadicacionOnlineRepository->crearAdjuntoGestion($nombre, $subirArchivo, $gestion['id']);
                }
            }
        }


        $afiliado = $this->radicacionOnlineRepository->datosparaEmail($request['radicacion_online_id']);
        Mail::send('alerta_radicacion_email', ['radicado_id' => $request['radicacion_online_id'], 'tipo' => 'Respuesta', 'name' => $afiliado->primer_nombre], function ($m) use ($afiliado) {
            $m->to($afiliado->correo1, $afiliado->primer_nombre)->subject('Notificación Radicación');
        });


        return '¡Ha dado respuesta a la solicitud con exito!';
    }

    public function asignar($request)
    {

        $this->radicacionOnlineRepository->actualizarEstadoPendiente($request['radicacion_online_id']);

        $usuarios = [];

        foreach ($request['usuarios'] as $usuario) {
            foreach ($usuario['user'] as $operador) {
                $this->gestionRadicacionOnlineRepository->crearGestion($request['radicacion_online_id'], $operador['id'], 20, 'Asignado', $usuario['id']);
            }

            // $usuarios[] = $this->empleadoRepository->buscaEmpleadoPorIdUsuario($usuario);
        }

        // Mail::send('radicacion_email',['radicado_id' => $request['radicacion_online_id'], 'tipo' => 'asignar'], function ($m) use ($usuarios) {
        //     foreach ($usuarios as $user) {
        //         $m->to($user->email, $user->primer_nombre)->subject('Notificación Radicación');
        // }
        //     });


        return '¡Ha asignado la solicitud con exito!';
    }

    public function devolver($request)
    {
        $this->radicacionOnlineRepository->actualizarEstadoPendiente($request['radicacion_online_id']);
        $this->gestionRadicacionOnlineRepository->quitarRegistro($request['radicacion_online_id']);
        $this->gestionRadicacionOnlineRepository->crearGestion($request['radicacion_online_id'], Auth::user()->id, 22, $request['motivo'], null);
        return '¡Ha devuelto la solicitud con exito!';
    }

    public function comentarAutogestion($request)
    {


        $tipo = $this->tipoRepository->buscarNombre('Comentarios al Solicitante');
        $gestion = $this->gestionRadicacionOnlineRepository->crearGestion($request['radicacion_online_id'], Auth::user()->id, $tipo->id, $request['motivo'], null);

        if ($request['adjuntos'] != 'null') {

            $archivos = $request['adjuntos'];
            $ruta = 'adjuntosRadicacion';
            if (sizeof($archivos) >= 1) {

                foreach ($archivos as $archivo) {
                    $nombreOriginal = $archivo->getClientOriginalName();
                    $nombre = $request['afiliado_id'] . '/' . $request['radicacion_online_id'] . '/' . time() . '_' . $nombreOriginal;
                    $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
                    $this->adjuntosRadicacionOnlineRepository->crearAdjuntoGestion($nombre, $subirArchivo, $gestion['id']);
                }
            }
        }

        //     $empleados = $this->gestionRadicacionOnlineRepository->datosparaEmailAuditoria($request['radicacion_online_id']);
        //     Mail::send('email_radicacion',['radicado_id' => $request['radicacion_online_id'], 'tipo' => 'Comentario'], function ($m) use ($empleados) {
        //         foreach($empleados as $empleado){
        //             $m->to($empleado->email, $empleado->primer_nombre)->subject('Notificación Radicación');
        //         }

        // });


        return '¡Ha comentado la solicitud con exito!';
    }
}
