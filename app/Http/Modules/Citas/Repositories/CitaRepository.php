<?php

namespace App\Http\Modules\Citas\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Modules\Citas\Models\Cita;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\LogsKeiron\models\LogsKeiron;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;

class CitaRepository extends RepositoryBase
{
    protected $citaModel;

    public function __construct()
    {
        $this->citaModel = new Cita();
        parent::__construct($this->citaModel);
    }

    public function citas($request, $user_id)
    {
        $entidadesUsuario = DB::table('entidad_users')
            ->where('user_id', $user_id)
            ->pluck('entidad_id');
        $citas = $this->citaModel->select([
            'citas.id',
            'citas.nombre as nombreCita',
            'citas.cantidad_paciente',
            'citas.tiempo_consulta',
            'citas.sms',
            'citas.requiere_orden',
            'citas.exento',
            'citas.primera_vez_cup_id',
            'citas.control_cup_id',
            'citas.especialidade_id',
            'citas.tipo_historia_id',
            'citas.modalidad_id',
            'citas.estado_id',
            'citas.tipo_cita_id',
            'citas.tipo_consulta_id',
            'citas.entidad_id',
            'especialidades.nombre as nombreEspecialidad',
            'especialidades.estado as estadoEspecialidad',
            'tipo_citas.nombre as nombreTipoCita',
            'tipo_citas.multiples',
            'tipo_citas.estado as estadoTipocita',
            'citas.requiere_firma',
            'citas.whatsapp',
            'citas.activo_autogestion'
        ])
            ->join('especialidades', 'citas.especialidade_id', 'especialidades.id')
            ->join('modalidades', 'citas.modalidad_id', 'modalidades.id')
            ->join('tipo_citas', 'citas.tipo_cita_id', 'tipo_citas.id')
            ->join('tipo_consultas', 'citas.tipo_consulta_id', 'tipo_consultas.id')
            ->whereIn('citas.entidad_id', $entidadesUsuario)
            ->orderBy('citas.id', 'desc')
            ->with('cups', 'modalidad', 'especialidad', 'tipoCita');

        if ($request->nombre) {
            $citas->where('citas.nombre', 'ILIKE', "%{$request->nombre}%");
        }

        return $request->page ? $citas->paginate($request->cant) : $citas->get();
    }

    public function listarCitas($tipo = 'telemedicina', $fecha = null)
    {
        $citas = Consulta::select([
            'a2.id as id',
            'consultas.id as historia',
            DB::raw("concat(a.primer_nombre,' ',a.segundo_nombre,' ',a.primer_apellido,' ',a.segundo_apellido) as nombre_paciente"),
            DB::raw("convert(date, a2.fecha_inicio) as fecha"),
            DB::raw("convert(time, a2.fecha_inicio) as hora"),
            'c2.tiempo_consulta as duracion_cita',
            'c2.nombre as actividad',
            'e.nombre as especialidad',
            'r2.nombre as nombreSede',
            'r2.direccion as direccionSede',
            DB::raw("concat(e2.primer_nombre,' ',e2.segundo_nombre,' ',e2.primer_apellido,' ',e2.segundo_apellido) as nombre_medico"),
            DB::raw("'TELEMEDICINA' observacion"),
            'consultas.estado_id as estado_cita',
            'a.correo1 as email_paciente',
            'a.numero_documento as documento_paciente',
            'e2.email_corporativo as email_medico',
            DB::raw("'telemedicina@sumimedical.com' as email_salida"),
            'consultas.updated_at as fecha_modificacion',
            'a.Celular1 as celular'
        ])->join('afiliados as a', 'a.id', 'consultas.afiliado_id')
            ->join('agendas as a2', 'consultas.agenda_id', 'a2.id')
            ->join('consultorios as c', 'a2.consultorio_id', 'c.id')
            ->join('reps as r2', 'c.rep_id', 'r2.id')
            ->join('agenda_user as au', 'a2.id', 'au.agenda_id')
            ->join('users as u', 'au.user_id', 'u.id')
            ->join('citas as c2', 'a2.cita_id', 'c2.id')
            ->join('especialidades as e', 'c2.especialidade_id', 'e.id')
            ->join('empleados as e2', 'u.id', 'e2.user_id')
            ->whereTipoDeConsulta($tipo, $fecha)
            ->whereModalidad($tipo)
            ->whereIn('consultas.estado_id', [13, 5])
            ->get();

        return $citas ?? false;
    }

    public function formatoMeet($data)
    {
        return $data->map(function ($item, $key) {
            return [
                "id" => $item->id,
                "historia" => $item->historia,
                "nombre_paciente" => $item->nombre_paciente,
                "documento_paciente" => $item->documento_paciente,
                "fecha" => $item->fecha,
                "hora" => explode('.', $item->hora)[0],
                "duracion_cita" => $this->formatoHora(intval($item->duracion_cita)),
                "especialidad" => $item->especialidad,
                "nombre_medico" => $item->nombre_medico,
                "observacion" => $item->observacion,
                "estado_cita" => $this->determinarEstado(intval($item->estado_cita)),
                "email_paciente" => $item->email_paciente,
                "email_medico" => $item->email_medico,
                "email_salida" => $item->email_salida,
                "fecha_modificacion" => $item->fecha_modificacion,
            ];
        });
    }

    private function formatoHora($minutos)
    {
        $objeto = (object) ['horas' => 0, 'minutos' => 0];

        $objeto->horas = floor($minutos / 60);
        $objeto->minutos = $minutos - ($objeto->horas * 60);

        return '0' . $objeto->horas . ':' . ($objeto->minutos < 10 ? '0' . $objeto->minutos : $objeto->minutos) . ':00';
    }

    public function determinarEstado($estado)
    {
        switch ($estado) {
            case 13:
                return 'P';
                break;
            case 5:
                return 'C';
                break;
            default:
                return 'Sin estado';
                break;
        }
    }

    public function consultarPorEspecialidad($data)
    {
        return $this->citaModel->where('especialidade_id', $data['especialidad_id'])->with('cups')->where('estado_id', 1)->first();

        // if($consulta){
        //     return true;
        // }else{
        //     return false;
        // }
    }

    public function consultarPorEspecialidadTodas($data)
    {
        if ($data['estado'] == 1) { //condicion, si se manda el param estado 1 desde el front se listan solo los tipos de cita activos
            return $this->citaModel
                ->where('especialidade_id', $data['data'])
                ->where('estado_id', 1)
                ->get();
        }

        return $this->citaModel->where('especialidade_id', $data['data'])->get();
    }

    public function citaOrdenPaciente($data)
    {
        $citaCup = $this->citaModel->where('especialidade_id', $data['especialidad_id'])->with('cups')->get();
        $cups = [];
        foreach ($citaCup as $key) {
            if (sizeof($key->cups) > 0) {
                foreach ($key->cups as $key2) {
                    $cups[] = $key2->id;
                }
            }
        }

        $newOrden = [];

        if (isset($cups)) {
            $ordenes = Consulta::select(
                'ordenes.created_at',
                'orden_procedimientos.orden_id',
                'orden_procedimientos.id as OrdenProcedimiento_id',
                'orden_procedimientos.observacion',
                'orden_procedimientos.cantidad',
                'orden_procedimientos.fecha_vigencia',
                'cups.nombre',
                'cups.id'
            )
                ->join('ordenes', 'ordenes.consulta_id', 'consultas.id')
                ->join('orden_procedimientos', 'orden_procedimientos.orden_id', 'ordenes.id')
                ->join('cups', 'cups.id', 'orden_procedimientos.cup_id')
                ->where('consultas.afiliado_id', $data['afiliado_id'])
                // ->whereIn('orden_procedimientos.estado_id',[1,14])
                ->whereIn('orden_procedimientos.cup_id', $cups)
                ->get();

            $ordens = [];

            foreach ($ordenes as $consultaCups) {
                $consultaPacienteCups = OrdenProcedimiento::where('orden_procedimientos.id', $consultaCups->OrdenProcedimiento_id)
                    ->join('ordenes', 'ordenes.id', 'orden_procedimientos.orden_id')
                    ->join('consultas', 'consultas.id', 'ordenes.consulta_id')
                    ->whereIn('consultas.estado_id', [13, 7, 9])
                    ->count();
                if ($consultaPacienteCups <= intval($consultaCups->cantidad)) {
                    $ordens[] = $consultaCups;
                }
            }

            foreach ($ordens as $key => $orden) {
                $fecha1 = Carbon::now()->format('Y-m-d');
                $fecha2 = Carbon::parse($orden->fecha_vigencia);
                $diasDiferencia = $fecha2->diffInDays($fecha1);
                if ($diasDiferencia < 0) {
                    $diasDiferencia = 0;
                }
                $orden['dias'] = $diasDiferencia;

                if (strpos($orden->nombre, 'CONTROL')) {
                    if (intval($orden->dias) <= 150) {
                        $newOrden[] = $orden;
                    }
                } else {
                    if (intval($orden->dias) <= 120) {
                        $newOrden[] = $orden;
                    }
                }
            }
        }

        return $newOrden;
    }


    public function listarCitasAutogestion()
    {
        return $this->citaModel->with('especialidad')->where('estado_id', 1)->where('activo_autogestion', 1)->get();
    }

    public function cambiarEstadoCita(array $request, int $id)
    {
        $cita = $this->citaModel->findOrFail($id);

        $cita->update([
            'estado_id' => $request['estado_id']


        ]);

        return $cita;
    }

    public function filtrarCitas($data)
    {
        $citas = $this->citaModel->select([
            'citas.id',
            'citas.nombre as nombreCita',
            'citas.cantidad_paciente',
            'citas.tiempo_consulta',
            'citas.sms',
            'citas.requiere_orden',
            'citas.primera_vez_cup_id',
            'citas.control_cup_id',
            'citas.especialidade_id',
            'citas.tipo_historia_id',
            'citas.modalidad_id',
            'citas.estado_id',
            'citas.tipo_cita_id',
            'especialidades.nombre as nombreEspecialidad',
            'especialidades.estado as estadoEspecialidad',
            'tipo_citas.nombre as nombreTipoCita',
            'tipo_citas.multiples',
            'tipo_citas.estado as estadoTipocita',
            'citas.requiere_firma',
            'citas.whatsapp',
        ])
            ->join('especialidades', 'citas.especialidade_id', 'especialidades.id')
            ->join('modalidades', 'citas.modalidad_id', 'modalidades.id')
            ->join('tipo_citas', 'citas.tipo_cita_id', 'tipo_citas.id')
            ->orderBy('citas.id', 'asc')
            ->with('cups', 'modalidad', 'especialidad', 'tipoCita');

        $citas->when(isset($data['nombre']), function ($query) use ($data) {
            $query->where('citas.nombre', 'ILIKE', "%{$data['nombre']}%");
        });

        $citas->when(isset($data['especialidade_id']), function ($query) use ($data) {
            $query->where('citas.especialidade_id', $data['especialidade_id']);
        });

        $citas->when(isset($data['modalidad_id']), function ($query) use ($data) {
            $query->where('citas.modalidad_id', $data['modalidad_id']);
        });

        $citas->when(isset($data['estado_id']), function ($query) use ($data) {
            $query->where('citas.estado_id', $data['estado_id']);
        });

        return $citas->get();
    }

    public function cambiarFirma(array $request, int $id)
    {
        $cita = $this->citaModel->findOrFail($id);

        $cita->update([
            'requiere_firma' => $request['requiere_firma']


        ]);

        return $cita;
    }

    public function obtenerCitaNombre($nombre)
    {
        return $this->citaModel->select(['citas.id'])
            ->where('nombre', $nombre)->first();
    }

    /**
     * listarRepPorCita
     * Listar los reps que tiene una cita especifica asociados
     *
     * @param  mixed $cita_id
     * @return void
     * @author Serna
     */
    public function listarRepPorCita(int $cita_id)
    {
        $cita = $this->citaModel::where('id', $cita_id)->first();
        return $cita->citasReps;
    }

    public function listarLogKeiron($request)
    {
        $logs = LogsKeiron::join('consultas', 'logs_keirons.consulta_id', 'consultas.id')
            ->join('afiliados', 'consultas.afiliado_id', 'afiliados.id')
            ->join('estados', 'consultas.estado_id', 'estados.id')
            ->select(
                'logs_keirons.id',
                'logs_keirons.consulta_id',
                'estados.nombre as estado_consulta',
                DB::raw("concat(afiliados.primer_nombre,' ',afiliados.segundo_nombre,' ',afiliados.primer_apellido,' ',afiliados.segundo_apellido) as nombre_afiliado"),
                'afiliados.numero_documento',
                'logs_keirons.status',
                'logs_keirons.transition_id',
                'logs_keirons.fecha_consulta',
                'logs_keirons.created_at',
                DB::raw(
                    "TO_CHAR(logs_keirons.created_at, 'YYYY-MM-DD HH24:MI:SS') as fecha_creacion"
                ),
                'logs_keirons.dealId'
            )
            ->when(isset($request['estado']), function ($query) use ($request) {
                $query->where('logs_keirons.status', $request['estado']);
            })
            ->when(isset($request['numero_documento']), function ($query) use ($request) {
                $query->where('afiliados.numero_documento', 'ILIKE', "%{$request['numero_documento']}%");
            })
            ->when(isset($request['idTransition']), function ($query) use ($request) {
                $query->where('logs_keirons.transition_id', $request['idTransition']);
            })
            ->when(isset($request['dealId']), function ($query) use ($request) {
                $query->where('logs_keirons.dealId', $request['dealId']);
            })
            ->orderBy('logs_keirons.created_at', 'desc');

        return $request['page'] ? $logs->paginate($request['cant']) : $logs->get();
    }

    // Contador de registros con errores en Keiron
    // Se filtran por estado 13 (Pendiente) y por whatsapp true
    // Se filtran por fecha de agenda desde el 15 de agosto de 2025
    // Se cuentan los registros que tienen errores en logs_keirons
    public function contadorFaltantesKeiron()
    {

        $contadorNoEnviadas = Consulta::leftJoin('logs_keirons as lk', 'consultas.id', '=', 'lk.consulta_id')
            ->join('afiliados as af', 'af.id', '=', 'consultas.afiliado_id')
            ->join('entidades as ent', 'ent.id', '=', 'af.entidad_id')
            ->join('citas as ct', 'ct.id', '=', 'consultas.cita_id')
            ->join('agendas', 'consultas.agenda_id', '=', 'agendas.id')
            ->join('consultorios', 'agendas.consultorio_id', '=', 'consultorios.id')
            ->join('reps', 'consultorios.rep_id', '=', 'reps.id')
            ->join('especialidades', 'ct.especialidade_id', '=', 'especialidades.id')
            ->join('agenda_user as as', 'agendas.id', 'as.agenda_id')
            ->join('operadores', 'as.user_id', '=', 'operadores.user_id')
            ->join('users as use', 'use.id', 'operadores.user_id')
            ->whereNull('lk.consulta_id')
            ->whereDate('agendas.fecha_inicio', '>=', '2025-09-04')
            ->where('consultas.estado_id', 13)
            ->where('ct.whatsapp', true)
            ->where('use.activo', true)
            ->count();

        $canceladasNoEnviadas = Consulta::leftJoin('logs_keirons as lk', 'consultas.id', '=', 'lk.consulta_id')
            ->join('afiliados as af', 'af.id', '=', 'consultas.afiliado_id')
            ->join('entidades as ent', 'ent.id', '=', 'af.entidad_id')
            ->join('citas as ct', 'ct.id', '=', 'consultas.cita_id')
            ->join('agendas', 'consultas.agenda_id', '=', 'agendas.id')
            ->join('consultorios', 'agendas.consultorio_id', '=', 'consultorios.id')
            ->join('reps', 'consultorios.rep_id', '=', 'reps.id')
            ->join('especialidades', 'ct.especialidade_id', '=', 'especialidades.id')
            ->join('agenda_user as as', 'agendas.id', 'as.agenda_id')
            ->join('operadores', 'as.user_id', '=', 'operadores.user_id')
            ->join('users as use', 'use.id', 'operadores.user_id')
            ->where('lk.status', '1286')
            ->whereNotNull('lk.dealId')
            ->whereNotNull('lk.consulta_id')
            ->whereDate('agendas.fecha_inicio', '>=', '2025-09-04')
            ->where('consultas.estado_id', 30)
            ->where('ct.whatsapp', true)
            ->where('use.activo', true)
            ->count();


        return ['no_enviadas' => $contadorNoEnviadas, 'canceladas_no_enviadas' => $canceladasNoEnviadas];
    }

    public function listarFaltantesKeiron(array $request)
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        $paginacion = $request['paginacion'];

        $masivo = DB::table('consultas')
            ->select(
                'consultas.id',
                'consultas.fecha_hora_inicio',
                DB::raw("CONCAT(af.primer_nombre, ' ', af.segundo_nombre, ' ', af.primer_apellido, ' ', af.segundo_apellido) AS paciente_nombre_completo"),
                'af.numero_documento AS paciente_numero_documento',
                'af.correo1 AS paciente_correo1',
                'af.celular1 AS paciente_celular1',
                'af.entidad_id AS paciente_entidad_id',
                'ent.nombre AS paciente_entidad_nombre',
                'reps.nombre AS sede_nombre',
                'reps.direccion AS sede_direccion',
                'especialidades.nombre AS especialidad_nombre',
                'ct.nombre AS cita_nombre',
                'lk.log_payload as log_errores',
                DB::raw("CONCAT(operadores.nombre, ' ', operadores.apellido) AS medico_nombre_completo"),
            )
            ->leftJoin('logs_keirons as lk', 'consultas.id', '=', 'lk.consulta_id')
            ->join('afiliados as af', 'af.id', '=', 'consultas.afiliado_id')
            ->join('entidades as ent', 'ent.id', '=', 'af.entidad_id')
            ->join('citas as ct', 'ct.id', '=', 'consultas.cita_id')
            ->join('agendas', 'consultas.agenda_id', '=', 'agendas.id')
            ->join('consultorios', 'agendas.consultorio_id', '=', 'consultorios.id')
            ->join('reps', 'consultorios.rep_id', '=', 'reps.id')
            ->join('especialidades', 'ct.especialidade_id', '=', 'especialidades.id')
            ->join('agenda_user as as', 'agendas.id', 'as.agenda_id')
            ->join('operadores', 'as.user_id', '=', 'operadores.user_id')
            ->join('users as use', 'use.id', 'operadores.user_id')
            ->whereNull('lk.consulta_id')
            ->whereDate('agendas.fecha_inicio', '>=', '2025-09-04')
            ->where('consultas.estado_id', $request['estado_id'])
            ->where('ct.whatsapp', true)
            ->where('use.activo', true);


        return $masivo->paginate($paginacion['cantidadRegistros'], ['*'], 'page', $paginacion['pagina']);

    }

    public function listarCanceladasFaltantesKeiron(array $request)
    {
        $paginacion = $request['paginacion'];

        $cancelacionesPendientes = DB::table('consultas')
            ->select(
                'consultas.id',
                'consultas.fecha_hora_inicio',
                'af.id as afiliado_id',
                DB::raw("CONCAT(af.primer_nombre, ' ', af.segundo_nombre, ' ', af.primer_apellido, ' ', af.segundo_apellido) AS paciente_nombre_completo"),
                'af.numero_documento AS paciente_numero_documento',
                'af.correo1 AS paciente_correo1',
                'af.celular1 AS paciente_celular1',
                'af.entidad_id AS paciente_entidad_id',
                'af.tipo_afiliado_id',
                'ent.nombre AS paciente_entidad_nombre',
                'reps.nombre AS sede_nombre',
                'reps.direccion AS sede_direccion',
                'especialidades.nombre AS especialidad_nombre',
                'ct.nombre AS cita_nombre',
                'af.numero_documento_cotizante',
                DB::raw("CONCAT(operadores.nombre, ' ', operadores.apellido) AS medico_nombre_completo"),

            )
            ->leftJoin('logs_keirons as lk', 'consultas.id', '=', 'lk.consulta_id')
            ->join('afiliados as af', 'af.id', '=', 'consultas.afiliado_id')
            ->join('entidades as ent', 'ent.id', '=', 'af.entidad_id')
            ->join('citas as ct', 'ct.id', '=', 'consultas.cita_id')
            ->join('agendas', 'consultas.agenda_id', '=', 'agendas.id')
            ->join('consultorios', 'agendas.consultorio_id', '=', 'consultorios.id')
            ->join('reps', 'consultorios.rep_id', '=', 'reps.id')
            ->join('especialidades', 'ct.especialidade_id', '=', 'especialidades.id')
            ->join('agenda_user as as', 'agendas.id', 'as.agenda_id')
            ->join('operadores', 'as.user_id', '=', 'operadores.user_id')
            ->join('users as use', 'use.id', 'operadores.user_id')
            ->where('lk.status', '1286')
            ->whereNotNull('lk.dealId')
            ->whereNotNull('lk.consulta_id')
            ->whereDate('agendas.fecha_inicio', '>=', '2025-09-04')
            ->where('consultas.estado_id', 30)
            ->where('ct.whatsapp', true)
            ->where('use.activo', true);

        return $cancelacionesPendientes->paginate($paginacion['cantidadRegistros'], ['*'], 'page', $paginacion['pagina']);

    }

    /**
     * Se busca la cita por el id diligenciado
     * @param int $id
     * @return object|null   // porque puede que no exista
     * @author jose vasquez 
     */
    public function buscarCitaPorId(int $id): ?object
    {
        return $this->citaModel->where('id', $id)->first();
    }
}
