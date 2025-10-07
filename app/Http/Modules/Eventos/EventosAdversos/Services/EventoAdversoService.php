<?php

namespace App\Http\Modules\Eventos\EventosAdversos\Services;

use App\Traits\ArchivosTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Modules\Eventos\Analisis\Models\AnalisisEvento;
use App\Http\Modules\Eventos\GestionEventos\Models\GestionEvento;
use App\Http\Modules\Eventos\EventosAdversos\Models\EventoAdverso;
use App\Http\Modules\Eventos\EventosAsignados\Models\EventoAsignado;
use App\Http\Modules\Eventos\Adjunto\Repositories\AdjuntoEventoAdversoRepository;
use App\Http\Modules\Eventos\EventosAdversos\Repositories\EventoAdversoRepository;
use App\Http\Modules\Eventos\EventosAsignados\Repositories\EventoAsignadoRepository;
use App\Http\Modules\Eventos\UsuariosSuceso\Repositories\UsuariosSucesoRepository;
use Error;
use Illuminate\Support\Facades\Mail;
use Rap2hpoutre\FastExcel\FastExcel;

class EventoAdversoService
{

    use ArchivosTrait;

    protected EventoAdversoRepository $eventoAdversoRepository;
    protected AdjuntoEventoAdversoRepository $adjuntoEventoRepository;
    protected EventoAsignado $eventoAsignado;
    protected EventoAdverso $eventoAdverso;
    protected GestionEvento $gestionEvento;

    public function __construct(
        EventoAdversoRepository $eventoAdversoRepository,
        AdjuntoEventoAdversoRepository $adjuntoEventoRepository,
        EventoAsignado $eventoAsignado,
        EventoAdverso $eventoAdverso,
        GestionEvento $gestionEvento,
        private UsuariosSucesoRepository $usuariosSucesoRepository,
        private EventoAsignadoRepository $eventoAsignadoRepository
    ) {
        $this->eventoAdversoRepository = $eventoAdversoRepository;
        $this->adjuntoEventoRepository = $adjuntoEventoRepository;
        $this->eventoAsignado = $eventoAsignado;
        $this->eventoAdverso = $eventoAdverso;
        $this->gestionEvento = $gestionEvento;
    }


    public function guardarEvento($data)
    {
        return DB::transaction(function () use ($data) {
            $eventoCreado = $this->eventoAdversoRepository->crear($data);

            #se obtienen los id de los usuarios asociados al evento
            $usuarioAsociado = $eventoCreado->load('suceso')->suceso->load('usuarioSuceso')->usuarioSuceso->pluck('user_id')->toArray();


            #si no hay usuarios asociados, se obtienen los usuarios por defecto
            if (empty($usuarioAsociado)) {
                $usuariosPorDefecto = $this->usuariosSucesoRepository->usuariosPorDefecto();
            }

            #si no se obtienen usuarios asociados se asginan los usuarios por defecto
            $asignaciones = !empty($usuarioAsociado) ?  $usuarioAsociado : $usuariosPorDefecto;

            $asignaciones = array_map(fn($userId) => [
                'evento_adverso_id' => $eventoCreado->id,
                'user_id' => $userId
            ], $asignaciones);


            EventoAsignado::insert($asignaciones);

            $this->gestionEvento::create([
                'accion' => 'Creacion',
                'evento_adverso_id' => $eventoCreado->id,
                'user_id' => Auth::id(),
                'motivo' => 'Creacion de evento adverso',
                'created_at' => now(),
            ]);

            $adjuntos = [];

            if (!empty($data['adjuntos'])) {
                $ruta = 'adjuntosEventoAdverso';

                foreach ($data['adjuntos'] as $archivo) {
                    $nombre = $archivo->getClientOriginalName();
                    $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');

                    $adjuntos[] = $this->adjuntoEventoRepository->crear([
                        'nombre' => $nombre,
                        'ruta' => $subirArchivo,
                        'evento_id' => $eventoCreado->id
                    ]);
                }
            }

            return (object)[
                'evento' => $eventoCreado,
                'adjuntos' => $adjuntos
            ];
        });
    }

    public function cerrarEventoAdverso($request)
    {
        return DB::transaction(function () use ($request) {
            EventoAdverso::where('id', $request['evento_adverso_id'])->update(['estado_id' => 17]);
            return GestionEvento::create([
                'accion' => 'Cerrado',
                'evento_adverso_id' => $request['evento_adverso_id'],
                'user_id' => Auth::id(),
                'motivo' => 'Severidad evento: ' . $request['severidad_evento'],
                'created_at' => now(),
            ]);
        });
    }

    public function devolver($request)
    {
        $eventoAdversoId = $request['evento_adverso_id'];
        $motivo_devolucion = $request['motivo_devolucion'];
        $estado_id = 10;

        return DB::transaction(function () use ($eventoAdversoId, $motivo_devolucion, $estado_id) {
            $this->eventoAsignado::where('evento_adverso_id', $eventoAdversoId)
                ->whereNotIn('user_id', [1539, 4347, 1990, 846706])
                ->delete();
            $dataGestion = [
                'accion' => 'Devolucion',
                'evento_adverso_id' => $eventoAdversoId,
                'user_id' => Auth::id(),
                'motivo' => $motivo_devolucion,
                'created_at' => now(),

            ];

            GestionEvento::insert($dataGestion);

            return EventoAdverso::where('id', $eventoAdversoId)->update(['estado_id' => $estado_id]);
        });
    }

    public function asignarEvento(array $request): bool
    {
        $eventoAdversoId = $request['evento_adverso_id'];
        $userIds = (array) $request['user_id'];
        $estado_id = 6;

        return DB::transaction(function () use (
            $eventoAdversoId,
            $userIds,
            &$estado_id,
            $request
        ) {
            $eventoAdverso = $this->eventoAdverso::findOrFail($eventoAdversoId);

            // Si ya tiene análisis, cambia estado
            if ($eventoAdverso->analisisEvento) {
                $estado_id = 16;
            }

            // Usuarios anteriores
            $usuariosAntiguos = $this->eventoAsignado::where('evento_adverso_id', $eventoAdversoId)
                ->with('user.operador')
                ->get()
                ->pluck('user')
                ->map(
                    fn($u) => $u->operador
                        ? trim("{$u->operador->nombre} {$u->operador->apellido}")
                        : ($u->email ?? 'No aplica')
                )
                ->implode(', ');

            // Usuarios nuevos
            $usuariosNuevos = User::whereIn('id', $userIds)
                ->with('operador')
                ->get();

            $nombresUsuariosNuevos = $usuariosNuevos
                ->map(
                    fn($u) => $u->operador
                        ? trim("{$u->operador->nombre} {$u->operador->apellido}")
                        : ($u->email ?? 'No aplica')
                )
                ->implode(', ');

            // Insertar nuevas asignaciones
            $this->eventoAsignado::insert(
                array_map(fn($id) => [
                    'evento_adverso_id' => $eventoAdversoId,
                    'user_id' => $id,
                ], $userIds)
            );

            // Actualizar evento
            $eventoAdverso->update([
                'estado_id' => $estado_id,
                'voluntariedad' => $request['voluntariedad'],
                'priorizacion' => $request['priorizacion'],
                'identificacion_riesgo' => $request['identificacion_riesgo']
            ]);

            // Registrar gestión
            $motivo = "Usuarios antiguos: $usuariosAntiguos | Usuarios nuevos: $nombresUsuariosNuevos";

            $this->gestionEvento::create([
                'evento_adverso_id' => $eventoAdversoId,
                'user_id' => Auth::id(),
                'accion' => 'Evento asignado',
                'motivo' => $motivo,
                'motivo_asignacion' => $request['motivo']
            ]);
            
            // Enviar correos
            foreach ($usuariosNuevos as $usuario) {
                try {
                    $correo = $usuario->email;
                    $asunto = "Asignación de Evento Adverso #{$eventoAdverso->id}";

                    $datos = [
                        'evento' => $eventoAdverso,
                        'usuario' => $usuario,
                        'motivo' => $request['motivo'],
                    ];

                    Mail::send('email_asignacion_evento', $datos, function ($mensaje) use ($correo, $asunto) {
                        $mensaje->to($correo)->subject($asunto);
                    });
                } catch (\Throwable $e) {
                    throw new Error("Error enviando correo de asignación de evento {$eventoAdversoId} a usuario {$usuario->id}: {$e->getMessage()}");
                }
            }

            return true;
        });
    }

    public function listarEventos($filters)
    {
        $eventos = $this->eventoAdversoRepository->listarEventos($filters);

        $plazos = ['Urgente' => 3, 'Prioritario' => 10, 'No prioritario' => 15];

        foreach ($eventos as $evento) {
            if ($evento->estado_id != 6) {
                $evento->diasPriorizacion = null;
                continue;
            }

            $asignacion = GestionEvento::where('evento_adverso_id', $evento->id)
                ->whereIn('accion', ['Asignar', 'Asignación', 'Asignacion', 'Re asignar', 'Evento asignado'])
                ->latest('created_at')
                ->first();

            if (!$asignacion || !isset($plazos[$evento->priorizacion])) {
                $evento->diasPriorizacion = null;
                continue;
            }

            $diasTranscurridos = now()->diffInDays($asignacion->created_at);

            $evento->diasPriorizacion = $plazos[$evento->priorizacion] - $diasTranscurridos - 1;
        }

        return $eventos;
    }

    public function actualizar(EventoAdverso $model, array $data)
    {

        $this->eventoAdversoRepository->actualizar($model, $data);

        #obtengo los usuarios asignados al suceso
        $usuariosAsignados = $this->usuariosSucesoRepository->listarUsuariosPorSuceso($data['suceso_id']);

        #si hay usuarios asignados, se asignan para crear el registro
        if (!empty($usuariosAsignados)) {
            $data['empleado_asignado'] = $usuariosAsignados;
            $this->eventoAsignadoRepository->crearRegistro($data);
        };
    }

    /**
     * @param array{id:int, estado_id:int} $data
     */
    public function actualizarEstado(array $data): bool
    {
        return $this->eventoAdverso
            ->where('id', $data['evento_adverso_id'])
            ->update(['estado_id' => $data['estado_id']]) > 0;
    }

    /**
     * descargarSeguimientoIAAS - Servicio para descargar el reporte de seguimiento IAAS
     *
     * @param  mixed $data
     * @return void
     */
    public function descargarSeguimientoIAAS(array $data)
    {
        $eventos = $this->eventoAdversoRepository->listarSeguimientoIAAS($data);

        $eventosArray = collect($eventos)->toArray();

        $mes  = (int) $data['mes'];
        $anio = (int) $data['anio'];
        $nombreArchivo = "Seguimiento_IAAS_{$mes}_{$anio}.xlsx";

        return (new FastExcel($eventosArray))->download($nombreArchivo);
    }
}
