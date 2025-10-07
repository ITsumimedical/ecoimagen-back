<?php

namespace App\Http\Modules\Consultas\Services;

use App\Events\EnviarKeiron;
use App\Jobs\EnviosKeironJob;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Modules\Citas\Models\Cita;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Agendas\Models\Agenda;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Auditorias\Models\Auditoria;
use App\Http\Modules\Citas\Repositories\CitaRepository;
use App\Http\Modules\CobroServicios\Services\CobroServicioService;
use App\Http\Modules\TipoConsultas\Models\TipoConsulta;
use App\Http\Modules\Ordenamiento\Models\OrdenCodigoPropio;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Modules\Consultas\Repositories\ConsultaRepository;
use App\Http\Modules\Consultas\Models\ConsultaOrdenProcedimientos;
use App\Http\Modules\Contratos\Services\ContratoService;
use App\Http\Modules\DemandaInsatisfecha\Models\DemandaInsatisfecha;
use Exception;
use App\Http\Modules\Especialidades\Repositories\EspecialidadRepository;
use App\Http\Modules\LogsKeiron\Services\KeironService;
use App\Http\Modules\TipoConsultas\Repositories\TipoConsultaRepository;

class ConsultaService
{
    public function __construct(
        protected ConsultaRepository $consultaRepository,
        private EspecialidadRepository $especialidadRepository,
        private CitaRepository $citaRepository,
        private TipoConsultaRepository $tipoConsultaRepository,
        private KeironService $keironService,
        private ContratoService $contratoService,
        private CobroServicioService $cobroServicioService
    ) {
    }

    public function guardar(array $request)
    {
        // return $request;
        $this->calcularEstadoAgenda($request["agenda"]["id"]);
        $pacientesAsignados = Consulta::where('agenda_id', $request["agenda"]["id"])
            ->where('afiliado_id', $request["paciente"]["id"])
            ->where('estado_id', 13)
            ->count();
        if ($pacientesAsignados === intval($request["cita"]['cantidad_paciente'])) {
            return ['mensaje' => '¡La cita ya se encuentra ocupada!', 'status' => 422];
        }

        if (!isset($request['agenda']['consultorio']['rep_id'])) {
            return ['mensaje' => 'No se encontró el rep asociado al consultorio', 'status' => 422];
        }

        if (isset($request['servicio_id'])) {
            $existeOrdenPaciente = null;

            // Verificar el tipo de orden
            if ($request['tipo_orden'] === 'procedimiento') {
                // Validación para órdenes de tipo procedimiento
                $existeOrdenPaciente = ConsultaOrdenProcedimientos::join('consultas', 'consultas.id', 'consulta_orden_procedimientos.consulta_id')
                    ->whereIn('consultas.estado_id', [13, 14, 67])
                    ->where('consulta_orden_procedimientos.orden_procedimiento_id', $request['servicio_id'])
                    ->first();
            } elseif ($request['tipo_orden'] === 'codigo_propio') {
                // Validación para órdenes de tipo código propio
                $existeOrdenPaciente = ConsultaOrdenProcedimientos::join('consultas', 'consultas.id', 'consulta_orden_procedimientos.consulta_id')
                    ->whereIn('consultas.estado_id', [13, 14, 67])
                    ->where('consulta_orden_procedimientos.orden_codigo_propio_id', $request['servicio_id'])
                    ->first();
            }

            if ($existeOrdenPaciente) {
                return [
                    'mensaje' => '¡El paciente ya tiene una cita asignada con esa Orden y Servicio!',
                    'status' => 422
                ];
            }
        }


        $agendaDisponible = Agenda::where('id', $request["agenda"]["id"])->where('estado_id', 11)->first();

        if ($agendaDisponible) {

            $desde = $agendaDisponible->fecha_inicio;
            $hasta = $agendaDisponible->fecha_fin;

            $disponibilidad = Agenda::join('consultas as c', 'c.agenda_id', 'agendas.id')
                ->where(function ($query) use ($desde, $hasta) {
                    $query->where(function ($query) use ($desde, $hasta) {
                        $query->where('agendas.fecha_inicio', '>', $desde)
                            ->where('agendas.fecha_inicio', '<', $hasta);
                    })
                        ->orWhere(function ($query) use ($desde, $hasta) {
                            $query->where('agendas.fecha_fin', '>', $desde)
                                ->where('agendas.fecha_fin', '<', $hasta);
                        })
                        ->orWhere(function ($query) use ($desde, $hasta) {
                            $query->where('agendas.fecha_inicio', $desde);
                        });
                })
                ->where('c.afiliado_id', $request["paciente"]["id"])
                ->where('agendas.estado_id', '!=', 5)
                ->where('c.estado_id', '!=', 5)
                ->whereNull('c.deleted_at')
                ->first();

            if ($disponibilidad) {
                return ['mensaje' => '¡El paciente tiene cita para ese día en ese rango de hora!', 'status' => 422];
            }

            $especialidadAsignada = Consulta::join('agendas as a', 'a.id', 'consultas.agenda_id')
                ->join('citas as c', 'c.id', 'a.cita_id')
                ->where('c.especialidade_id', $request["especialidad"]["id"])
                ->where('a.cita_id', $request['cita']['id'])
                ->where('consultas.afiliado_id', $request["paciente"]["id"])
                ->whereIn('consultas.estado_id', [13, 14, 67])
                ->first();

            if ($especialidadAsignada) {
                return ['mensaje' => '¡El paciente ya tiene una cita del mismo tipo!', 'status' => 422];
            }

            $tipoCita = ['Psicologia ocupacional', 'Voz ocupacional', 'Visiometria ocupacional', 'Consulta Medica ocupacional'];
            $tipoCitaOtro = ['Consulta Medica ocupacional'];
            $cupO = [2013, 2358, 2344, 71];

            if ($request['especialidad']['nombre'] === "Examenes ocupacionales periódicos" || $request['especialidad']['nombre'] === "Examenes ocupacionales egreso" || $request['especialidad']['nombre'] === "Examenes ocupacionales ingreso") {
                // return $request['agenda']['consultorio']['rep_id'];
                foreach ($tipoCita as $key => $tipo) {
                    $tipo = TipoConsulta::where('nombre', $tipo)->first();
                    $consulta = new Consulta();
                    $consulta->agenda_id = intval($request["agenda"]['id']);
                    $consulta->especialidad_id = $request["especialidad"]["id"];
                    $consulta->cup_id = $cupO[$key];
                    ;
                    $consulta->tipo_consulta_id = $tipo->id;
                    $consulta->rep_id = $request['agenda']['consultorio']['rep_id'];
                    $consulta->cita_id = intval($request["cita"]['id']);
                    $consulta->estado_id = 13;
                    $consulta->afiliado_id = intval($request["paciente"]["id"]);
                    $consulta->user_id = auth()->user()->id;
                    $consulta->save();
                }
                $agenda = Agenda::find($request["agenda"]['id']);
                $agenda->estado_id = 6;
                $agenda->save();
                return ['mensaje' => 'Cita asignada al afiliado con exito!', 'status' => 200, 'id' => $consulta->id];
            } elseif (
                $request['especialidad']['nombre'] === "Examenes ocupacionales post incapacidad" ||
                $request['especialidad']['nombre'] === "Examenes ocupacionales reubicación" ||
                $request['especialidad']['nombre'] === "Examenes ocupacionales para participar en eventos deportivos" ||
                $request['especialidad']['nombre'] === "Examenes ocupacionales para participar en eventos folcloricos"

            ) {
                // return $tipoCitaOtro;
                foreach ($tipoCitaOtro as $key => $tipo) {
                    $tipo = TipoConsulta::where('nombre', $tipo)->first();
                    $consulta = new Consulta();
                    $consulta->agenda_id = intval($request["agenda"]['id']);
                    $consulta->especialidad_id = $request["especialidad"]["id"];
                    $consulta->cup_id = $cupO[$key];
                    $consulta->tipo_consulta_id = $tipo->id;
                    $consulta->cita_id = intval($request["cita"]['id']);
                    $consulta->rep_id = $request['agenda']['consultorio']['rep_id'];
                    $consulta->estado_id = 13;
                    $consulta->afiliado_id = intval($request["paciente"]["id"]);
                    $consulta->user_id = auth()->user()->id;
                    $consulta->save();
                }
                $agenda = Agenda::find($request["agenda"]['id']);
                $agenda->estado_id = 6;
                $agenda->save();
                return ['mensaje' => 'Cita asignada al afiliado con exito!', 'status' => 200, 'id' => $consulta->id];
            } else {
                // return $request;
                $ciclo_vida = '';
                if (intval($request["paciente"]["edad_cumplida"]) <= 5) {
                    $ciclo_vida = 'Primera Infancia (0-5 Años)';
                } else if (intval($request["paciente"]["edad_cumplida"]) >= 6 && intval($request["paciente"]["edad_cumplida"]) <= 11) {
                    $ciclo_vida = 'Infancia (6-11 Años)';
                } else if (intval($request["paciente"]["edad_cumplida"]) >= 12 && intval($request["paciente"]["edad_cumplida"]) <= 17) {
                    $ciclo_vida = 'Adolescencia (12 A 17 Años)';
                } else if (intval($request["paciente"]["edad_cumplida"]) >= 18 && intval($request["paciente"]["edad_cumplida"]) <= 28) {
                    $ciclo_vida = 'Joven (18 A 28 Años)';
                } else if (intval($request["paciente"]["edad_cumplida"]) >= 29 && intval($request["paciente"]["edad_cumplida"]) <= 59) {
                    $ciclo_vida = 'Adulto (29 A 59 Años)';
                } else {
                    $ciclo_vida = 'Vejez (Mayor a 60 Años)';
                }
                $consulta = new Consulta();
                $consulta->fecha_hora_inicio = $request["agenda"]['fecha_inicio'];
                $consulta->fecha_hora_final = $request["agenda"]['fecha_fin'];
                $consulta->agenda_id = $request["agenda"]['id'];
                $consulta->especialidad_id = $request["especialidad"]["id"];
                $consulta->medico_ordena_id = $request["medico"] ? $request["medico"]['id'] : auth()->id();
                $consulta->tipo_consulta_id = $request["cita"]['tipo_consulta_id'];
                $consulta->fecha_solicitada = $request['fecha_solicitada'];
                $consulta->cup_id = $this->calcularCupControl(intval($request["paciente"]["id"]), intval($request["cita"]['id']));
                $consulta->cita_id = $request["cita"]['id'];
                $consulta->ciclo_vida_atencion = $ciclo_vida;
                $consulta->estado_id = 13;
                $consulta->afiliado_id = $request["paciente"]["id"];
                $consulta->rep_id = $request['agenda']['consultorio']['rep_id'];
                $consulta->user_id = auth()->user()->id;
                $consulta->observacion_agenda = $request["observacion"];
                $consulta->save();

                $demandaInsatisfecha = DemandaInsatisfecha::select('demanda_insatisfechas.id', 'demanda_insatisfechas.especialidad_id', 'demanda_insatisfechas.cita_id', 'demanda_insatisfechas.consulta_id')
                    ->where('afiliado_id', $request['paciente']['id'])
                    ->where('consulta_id', null)
                    ->first();

                if ($demandaInsatisfecha) {
                    if ($request['especialidad']['id'] == $demandaInsatisfecha['especialidad_id'] && $request['cita']['id'] == $demandaInsatisfecha['cita_id']) {
                        $demandaInsatisfecha->update([
                            'consulta_id' => $consulta->id
                        ]);
                    }
                }
                $this->calcularEstadoAgenda($request["agenda"]['id']);

                if (isset($request['servicio_id'])) {
                    // Verificar el tipo de orden
                    if ($request['tipo_orden'] === 'procedimiento') {
                        // Validación y guardado para tipo procedimiento
                        $idcups = OrdenProcedimiento::where('id', $request['servicio_id'])->first();
                        ConsultaOrdenProcedimientos::create([
                            'orden_procedimiento_id' => $request['servicio_id'], // Inserta en orden_procedimiento_id
                            'consulta_id' => $consulta->id,
                            'cantidad_usada' => $request['cantidad_usada'],
                            'user_id' => Auth::user()->id
                        ]);
                        // Actualiza el cup_id en la tabla Consulta
                        $cupOrden = ConsultaOrdenProcedimientos::where('orden_procedimiento_id', $request['servicio_id'])
                            ->where('consulta_id', $consulta->id)->first();
                        Consulta::find($cupOrden->consulta_id)
                            ->update([
                                'cup_id' => intval($idcups->cup_id)
                            ]);

                        // Marcar el OrdenProcedimiento en estado "Usada"
                        $procedimiento = OrdenProcedimiento::where('id', $request['servicio_id'])->first();
                        $procedimiento->cantidad_usada = $request['cantidad_usada'];
                        $procedimiento->cantidad_pendiente = $request['cantidad_pendiente'];
                        $procedimiento->estado_id = $request['cantidad_pendiente'] == 0 ? 54 : 1;
                        if ($request['cantidad_pendiente'] == 0) {
                            $procedimiento->estado_id_gestion_prestador = 58;
                            $procedimiento->fecha_sugerida = $request['fecha_solicitada'];
                            $procedimiento->fecha_solicitada = $request['fecha_solicitada'];
                            $procedimiento->observaciones = $request["observacion"];
                            //                            $procedimiento->responsable =
                        }
                        $procedimiento->save();
                    } elseif ($request['tipo_orden'] === 'codigo_propio') {
                        // Validación y guardado para tipo código propio

                        $idcups = OrdenCodigoPropio::where('id', $request['servicio_id'])->first();


                        ConsultaOrdenProcedimientos::create([
                            'orden_codigo_propio_id' => $request['servicio_id'], // Inserta en orden_codigo_propio_id
                            'consulta_id' => $consulta->id,
                            'cantidad_usada' => $request['cantidad_usada'],
                            'user_id' => Auth::user()->id
                        ]);


                        // Actualiza el cup_id en la tabla Consulta
                        $cupOrden = ConsultaOrdenProcedimientos::where('orden_codigo_propio_id', $request['servicio_id'])
                            ->where('consulta_id', $consulta->id)->first();
                        Consulta::find($cupOrden->consulta_id)
                            ->update([
                                'cup_id' => intval($idcups->codigoPropio->cup_id)
                            ]);

                        // Marcar el OrdenCodigoPropio en estado "Usada"
                        $procedimientoPropio = OrdenCodigoPropio::where('id', $request['servicio_id'])->first();
                        $procedimientoPropio->cantidad_usada = $request['cantidad_usada'];
                        $procedimientoPropio->cantidad_pendiente = $request['cantidad_pendiente'];
                        $procedimientoPropio->estado_id = $request['cantidad_pendiente'] == 0 ? 54 : 1;
                        if ($request['cantidad_pendiente'] == 0) {
                            $procedimientoPropio->estado_id_gestion_prestador = 58;
                            $procedimientoPropio->fecha_sugerida = $request['fecha_solicitada'];
                            $procedimientoPropio->fecha_solicitada = $request['fecha_solicitada'];
                            $procedimientoPropio->observaciones = $request["observacion"];
                        }
                        $procedimientoPropio->save();
                    }
                }


                EnviosKeironJob::dispatch($request, $consulta, 1)->onQueue('envios-keiron-crm');

                $this->contratoService->cobroAgendamiento($consulta->id);

                return ['mensaje' => 'Cita asignada al afiliado con exito!', 'status' => 200, 'id' => $consulta->id];
            }
        } else {
            return ['mensaje' => '¡No está disponible esta cita!', 'status' => 422];
        }
    }

    public function calcularEstadoAgenda($id)
    {
        $citasAsignadas = Consulta::where('agenda_id', $id)->whereIn('estado_id', [14, 13, 7, 9, 6])->count();
        $agenda = Agenda::find($id);
        $cantidadDisponible = intval($agenda->cita["cantidad_paciente"]);
        if ($agenda->cita["procedimiento_no_especifico"]) {
            $cantidadDisponible = intval($agenda->cantidad);
        }

        if ($citasAsignadas >= $cantidadDisponible) {
            $agenda->estado_id = 9;
        } else {
            $agenda->estado_id = 11;
        }

        $agenda->save();

        return $agenda;
    }

    public function calcularCupControl($idAfiliado, $idCita)
    {
        $cita = Cita::find($idCita);
        $cup_id = $cita->primera_vez_cup_id;
        $consultaPrimeraVez = Consulta::join('agendas as a', 'consultas.agenda_id', 'a.id')
            ->where('afiliado_id', $idAfiliado)
            ->whereYear('fecha_hora_inicio', date('Y'))
            ->where('a.cita_id', $cita->id)
            ->first();
        if ($consultaPrimeraVez) {
            $cup_id = $cita->control_cup_id;
        }
        return $cup_id;
    }

    public function cancelar($request)
    {
        // Buscar si la consulta está activa
        $consultaActiva = Consulta::where('id', $request["consulta"])
            ->where('afiliado_id', $request["afiliado"])
            ->whereIn('estado_id', [13, 14, 59, 67])
            ->first();

        if ($consultaActiva) {
            // Verificar si la consulta tiene una orden asociada
            $ordenConsulta = ConsultaOrdenProcedimientos::where('consulta_id', $consultaActiva->id)->first();

            if ($ordenConsulta) {
                // Si tiene una orden asociada a un código propio
                if (!is_null($ordenConsulta->orden_codigo_propio_id)) {
                    // Buscar en la auditoría
                    $auditoriaOrdenCodigoPropio = Auditoria::where('orden_codigo_propio_id', $ordenConsulta->orden_codigo_propio_id)->first();

                    // Actualizar el estado de la orden código propio
                    $ordenAntes = OrdenCodigoPropio::find($ordenConsulta->orden_codigo_propio_id);
                    OrdenCodigoPropio::where('id', $ordenConsulta->orden_codigo_propio_id)->update([
                        'estado_id' => $auditoriaOrdenCodigoPropio ? 4 : 1,
                        'cantidad_usada' => $ordenAntes->cantidad_usada - 1,
                        'cantidad_pendiente' => $ordenAntes->cantidad_pendiente + 1
                    ]);

                    // Si tiene una orden asociada a un procedimiento
                } elseif (!is_null($ordenConsulta->orden_procedimiento_id)) {
                    // Buscar en la auditoría
                    $auditoriaOrdenProcedimiento = Auditoria::where('orden_procedimiento_id', $ordenConsulta->orden_procedimiento_id)->first();

                    // Actualizar el estado de la orden procedimiento
                    $ordenAntes = OrdenProcedimiento::find($ordenConsulta->orden_procedimiento_id);
                    OrdenProcedimiento::where('id', $ordenConsulta->orden_procedimiento_id)->update([
                        'estado_id' => $auditoriaOrdenProcedimiento ? 4 : 1,
                        'cantidad_usada' => $ordenAntes->cantidad_usada - 1,
                        'cantidad_pendiente' => $ordenAntes->cantidad_pendiente + 1
                    ]);
                }

                $ordenConsulta->delete();
            }

            EnviosKeironJob::dispatch($request, null, 2)->onQueue('envios-keiron-crm');

            // Actualizar la consulta a estado de cancelación
            $consultaActiva->funcionario_cancela = auth()->user()->id;
            $consultaActiva->motivo_cancelacion = $request["motivoCancelacion"];
            $consultaActiva->estado_id = 30; // Estado de cancelación
            $consultaActiva->save();

            // Eliminar la consulta
            $consultaActiva->delete();

            // Recalcular el estado de la agenda asociada
            $this->calcularEstadoAgenda($consultaActiva->agenda_id);
            $this->consultaRepository->actualizarEstadoGestion($consultaActiva->id, 30);


            return ['mensaje' => 'Cita cancelada con éxito!', 'status' => 200];
        } else {
            return ['mensaje' => 'La cita ya no se encuentra asociada al afiliado.', 'status' => 422];
        }
    }



    public function reasignar($request)
    {
        $pacientesAsignados = Consulta::where('agenda_id', $request["agenda"]["id"])->where('afiliado_id', $request["paciente"]["id"])->where('estado_id', 13)->count();
        if ($pacientesAsignados === intval($request["consulta"]["agenda"]["cita"]['cantidad_paciente'])) {
            return ['mensaje' => '¡La cita ya se encuentra ocupada!', 'status' => 422];
        }

        $agendaDisponible = Agenda::where('id', $request["agenda"]["id"])->where('estado_id', 11)->first();
        if ($agendaDisponible) {
            $desde = $agendaDisponible->fecha_inicio;
            $hasta = $agendaDisponible->fecha_fin;

            $disponibilidad = Agenda::join('consultas as c', 'c.agenda_id', 'agendas.id')
                ->where(function ($query) use ($desde, $hasta) {
                    $query->where(function ($query) use ($desde, $hasta) {
                        $query->where('agendas.fecha_inicio', '>', $desde)
                            ->where('agendas.fecha_inicio', '<', $hasta);
                    })
                        ->orWhere(function ($query) use ($desde, $hasta) {
                            $query->where('agendas.fecha_fin', '>', $desde)
                                ->where('agendas.fecha_fin', '<', $hasta);
                        })
                        ->orWhere(function ($query) use ($desde, $hasta) {
                            $query->where('agendas.fecha_inicio', $desde);
                        });
                })
                ->where('c.afiliado_id', $request["paciente"]["id"])
                ->where('agendas.estado_id', '!=', 5)->first();

            if ($disponibilidad) {
                return ['mensaje' => '¡El paciente tiene cita para ese día en ese rango de hora!', 'status' => 422];
            }

            $consulta = Consulta::find($request["consulta"]["id"]);
            $consulta->agenda_id = $request["agenda"]["id"];
            $consulta->fecha_hora_inicio = $request["agenda"]["fecha_inicio"];
            $consulta->fecha_hora_final = $request["agenda"]["fecha_fin"];
            $consulta->cup_id = $this->calcularCupControl(intval($request["paciente"]["id"]), intval($request["agenda"]["cita"]['id']));
            $consulta->user_id = auth()->user()->id;
            $consulta->save();
            $this->calcularEstadoAgenda($request["consulta"]["agenda"]["id"]);
            $this->calcularEstadoAgenda($request["agenda"]["id"]);
        }

        return ['mensaje' => 'Cita reasignada con exito!.', 'status' => 200];
    }

    public function confirmar($request)
    {
        $consulta = Consulta::findOrFail($request['consulta']);

        if ($consulta->estado_id === 9) {
            throw new Exception('Esta cita ya ha sido Atendida, Por lo tanto No se puede Confirmar', 422);
        }

        $consulta->update(['estado_id' => 59,]);

        return 'OK';
    }

    public function consultarCita($consulta_id)
    {
        $cita = Consulta::select(
            'consultas.*',
            'especialidades.nombre as especialidad',
            'afiliados.primer_nombre',
            'afiliados.segundo_nombre',
            'afiliados.primer_apellido',
            'afiliados.segundo_apellido',
            'afiliados.numero_documento',
            'afiliados.edad_cumplida',
            DB::raw("concat(afiliados.primer_nombre,' ',afiliados.segundo_nombre,' ',afiliados.primer_apellido,' ',afiliados.segundo_apellido) as nombre_paciente"),
            DB::raw("CONCAT(p.primer_nombre,' ',p.segundo_nombre,' ',p.primer_apellido,' ',p.segundo_apellido) as nombreRepresentante"),
            'p.numero_documento as docRepresentante'
        )
            ->join('afiliados', 'afiliados.id', 'consultas.afiliado_id')
            ->join('agendas', 'agendas.id', 'consultas.agenda_id')
            ->join('citas', 'citas.id', 'agendas.cita_id')
            ->join('especialidades', 'especialidades.id', 'citas.especialidade_id')
            ->leftjoin('afiliados as p', 'afiliados.numero_documento_cotizante', 'p.numero_documento')
            ->without(['afiliado', 'estado'])
            ->where('consultas.id', $consulta_id)->first();

        return $cita;
    }

    public function consultarTelemedicina($consulta_id)
    {
        $cita = Consulta::select(
            'especialidades.nombre as especialidad',
            'afiliados.primer_nombre',
            'afiliados.segundo_nombre',
            'afiliados.primer_apellido',
            'afiliados.segundo_apellido',
            'afiliados.numero_documento',
            'afiliados.edad_cumplida',
            'consultas.firma_consentimiento',
            'consultas.firma_consentimiento_time'
        )
            ->join('afiliados', 'afiliados.id', 'consultas.afiliado_id')
            ->join('agendas', 'agendas.id', 'consultas.agenda_id')
            ->join('citas', 'citas.id', 'agendas.cita_id')
            ->join('especialidades', 'especialidades.id', 'citas.especialidade_id')
            ->where('consultas.id', intval($consulta_id['consulta_id']))->first();

        return $cita;
    }

    public function verificarEstadoConsulta($consulta_id)
    {
        // Verificar el médico que atiende
        $this->consultaRepository->verificarMedicoAtiende($consulta_id);

        $consulta = Consulta::find($consulta_id);
        if ($consulta->estado_id == 13 || $consulta->estado_id == 59) {
            $consulta->hora_inicio_atendio_consulta = Carbon::now();
            $consulta->save();
        }
        return $consulta;
    }

    public function consultasAtendidasPaciente($afiliado)
    {
        return Consulta::withTrashed()
            ->with([
                'agenda.consultorio.rep',
                'cita',
                'user',
                'funcionarioCancela.operador',
                'estado:id,nombre',
                'cita.especialidad',
                'user.operador',
                'agenda.medicos.operador',
                'consultaOrdenProcedimientos:id,orden_procedimiento_id,orden_codigo_propio_id,user_id,consulta_id',
                'consultaOrdenProcedimientos.ordenProcedimiento:id,cup_id,rep_id,cantidad,orden_id,observacion',
                'consultaOrdenProcedimientos.ordenProcedimiento.cup:id,codigo,nombre',
                'consultaOrdenProcedimientos.ordenProcedimiento.rep:id,nombre',
                'consultaOrdenProcedimientos.ordenProcedimiento.orden:id,tipo_orden_id,user_id',
                'consultaOrdenProcedimientos.ordenProcedimiento.orden.user:id',
                'consultaOrdenProcedimientos.ordenProcedimiento.orden.user.operador'
            ])
            ->where('afiliado_id', $afiliado)
            ->where('cita_no_programada', '!=', true)
            ->whereIn('estado_id', [30, 8, 9])
            ->whereNull('finalidad')
            ->paginate(request('per_page', 10));
    }

    public function asignarCitaAutogestion($request)
    {
        $this->calcularEstadoAgenda($request["agenda"]["id"]);
        $pacientesAsignados = Consulta::where('agenda_id', $request["agenda"]["id"])
            ->where('afiliado_id', $request["paciente"]["id"])
            ->where('estado_id', 13)
            ->count();
        if ($pacientesAsignados === intval($request["cita"]['cantidad_paciente'])) {
            return ['mensaje' => '¡La cita ya se encuentra ocupada!', 'status' => 422];
        }

        $agendaDisponible = Agenda::where('id', $request["agenda"]["id"])->where('estado_id', 11)->first();

        if ($agendaDisponible) {
            $desde = $agendaDisponible->fecha_inicio;
            $hasta = $agendaDisponible->fecha_fin;

            $disponibilidad = Agenda::join('consultas as c', 'c.agenda_id', 'agendas.id')
                ->where(function ($query) use ($desde, $hasta) {
                    $query->where(function ($query) use ($desde, $hasta) {
                        $query->where('agendas.fecha_inicio', '>', $desde)
                            ->where('agendas.fecha_inicio', '<', $hasta);
                    })
                        ->orWhere(function ($query) use ($desde, $hasta) {
                            $query->where('agendas.fecha_fin', '>', $desde)
                                ->where('agendas.fecha_fin', '<', $hasta);
                        })
                        ->orWhere(function ($query) use ($desde, $hasta) {
                            $query->where('agendas.fecha_inicio', $desde);
                        });
                })
                ->where('c.afiliado_id', $request["paciente"]["id"])
                ->where('agendas.estado_id', '!=', 5)
                ->where('c.estado_id', '!=', 5)
                ->first();

            if ($disponibilidad) {
                return ['mensaje' => '¡Señor afiliado, usted ya tiene una cita para ese día en ese rango de hora!', 'status' => 422];
            }

            $especialidadAsignada = Consulta::join('agendas as a', 'a.id', 'consultas.agenda_id')
                ->join('citas as c', 'c.id', 'a.cita_id')
                ->where('c.especialidade_id', $request["cita"]["especialidad"]["id"])
                ->where('a.cita_id', $request['cita']['id'])
                ->where('consultas.afiliado_id', $request["paciente"]["id"])
                ->whereIn('consultas.estado_id', [13, 14])
                ->first();

            if ($especialidadAsignada) {
                return ['mensaje' => '¡Señor afiliado, usted ya tiene una cita del mismo tipo!', 'status' => 422];
            }

            $ciclo_vida = '';
            if (intval($request["paciente"]["edad_cumplida"]) <= 5) {
                $ciclo_vida = 'Primera Infancia (0-5 Años)';
            } else if (intval($request["paciente"]["edad_cumplida"]) >= 6 && intval($request["paciente"]["edad_cumplida"]) <= 11) {
                $ciclo_vida = 'Infancia (6-11 Años)';
            } else if (intval($request["paciente"]["edad_cumplida"]) >= 12 && intval($request["paciente"]["edad_cumplida"]) <= 17) {
                $ciclo_vida = 'Adolescencia (12 A 17 Años)';
            } else if (intval($request["paciente"]["edad_cumplida"]) >= 18 && intval($request["paciente"]["edad_cumplida"]) <= 28) {
                $ciclo_vida = 'Joven (18 A 28 Años)';
            } else if (intval($request["paciente"]["edad_cumplida"]) >= 29 && intval($request["paciente"]["edad_cumplida"]) <= 59) {
                $ciclo_vida = 'Adulto (29 A 59 Años)';
            } else {
                $ciclo_vida = 'Vejez (Mayor a 60 Años)';
            }
            $consulta = new Consulta();
            $consulta->fecha_hora_inicio = $request["agenda"]['fecha_inicio'];
            $consulta->fecha_hora_final = $request["agenda"]['fecha_fin'];
            $consulta->agenda_id = $request["agenda"]['id'];
            $consulta->especialidad_id = $request["cita"]["especialidad"]["id"];
            $consulta->medico_ordena_id = $request["medico"] ? $request["medico"]['id'] : auth()->id();
            $consulta->tipo_consulta_id = $request["cita"]['tipo_consulta_id'];
            $consulta->fecha_solicitada = $request['fecha_solicitada'];
            $consulta->cup_id = $this->calcularCupControl(intval($request["paciente"]["id"]), intval($request["cita"]['id']));
            $consulta->cita_id = $request["cita"]['id'];
            $consulta->ciclo_vida_atencion = $ciclo_vida;
            $consulta->estado_id = 13;
            $consulta->rep_id = $request['agenda']['consultorio']['rep_id'];
            $consulta->afiliado_id = $request["paciente"]["id"];
            $consulta->user_id = auth()->user()->id;
            $consulta->save();

            $this->calcularEstadoAgenda($request["agenda"]['id']);

            return ['mensaje' => 'Su cita ha sido asignada exitosamente', 'status' => 200, 'id' => $consulta->id];
        } else {
            return ['mensaje' => '¡No está disponible esta cita!', 'status' => 422];
        }
    }

    public function historicoCitasAfiliado()
    {
        $afiliado = Afiliado::where('user_id', auth()->user()->id)->first();

        $consultas = Consulta::with([
            'especialidad',
            'medicoOrdena.operador',
            'cita',
            'agenda.consultorio.rep',
            'estado'
        ])
            ->where('agenda_id', '!=', null)
            ->where('afiliado_id', $afiliado->id)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return $consultas;
    }

    public function confirmarAdmision($request)
    {
        $consulta = Consulta::find($request['consulta']);
        $consulta->estado_id = 14;
        $consulta->firma_paciente = $request['firma'];
        $consulta->firma_acompanante = $request['firmaAcompanante'];
        $consulta->save();
        if ($request['medio_pago'] != 'null') {
            $datos = [
                'medio_pago' => $request['medio_pago']
            ];
            $this->cobroServicioService->registrarCobro($consulta['cobro']['id'], $datos);
        }

        return 'OK';
    }

    public function guardarFirmaConsentimiento($request)
    {
        Consulta::find($request['consulta_id'])->update([
            'estado_id' => 14,
            'firma_paciente' => $request['firma'],
            'firma_consentimiento' => $request['firma'],
            'firma_consentimiento_time' => now()
        ]);
        return 'OK';
    }

    public function guardarFirma($request)
    {
        Consulta::find($request['consulta'])->update([
            'firma_paciente' => $request['firma'],
            'firma_acompanante' => $request['firmaAcompanante']
        ]);
        return 'OK';
    }

    public function asignarSinRestricciones($request)
    {
        $agendaDisponible = Agenda::where('id', $request["agenda"]["id"])->where('estado_id', 11)->first();

        if ($agendaDisponible) {

            $desde = $agendaDisponible->fecha_inicio;
            $hasta = $agendaDisponible->fecha_fin;

            $disponibilidad = Agenda::join('consultas as c', 'c.agenda_id', 'agendas.id')
                ->where(function ($query) use ($desde, $hasta) {
                    $query->where(function ($query) use ($desde, $hasta) {
                        $query->where('agendas.fecha_inicio', '>', $desde)
                            ->where('agendas.fecha_inicio', '<', $hasta);
                    })
                        ->orWhere(function ($query) use ($desde, $hasta) {
                            $query->where('agendas.fecha_fin', '>', $desde)
                                ->where('agendas.fecha_fin', '<', $hasta);
                        })
                        ->orWhere(function ($query) use ($desde, $hasta) {
                            $query->where('agendas.fecha_inicio', $desde);
                        });
                })
                ->where('c.afiliado_id', $request["paciente"]["id"])
                ->where('agendas.estado_id', '!=', 5)
                ->where('c.estado_id', '!=', 5)
                ->whereNull('c.deleted_at')
                ->first();

            if ($disponibilidad) {
                return ['mensaje' => '¡El paciente tiene cita para ese día en ese rango de hora!', 'status' => 422];
            }

            $especialidadAsignada = Consulta::join('agendas as a', 'a.id', 'consultas.agenda_id')
                ->join('citas as c', 'c.id', 'a.cita_id')
                ->where('c.especialidade_id', $request["especialidad"]["id"])
                ->where('a.cita_id', $request['cita']['id'])
                ->where('consultas.afiliado_id', $request["paciente"]["id"])
                ->whereIn('consultas.estado_id', [13, 14])
                ->first();

            if ($especialidadAsignada) {
                return ['mensaje' => '¡El paciente ya tiene una cita del mismo tipo!', 'status' => 422];
            }

            $tipoCita = ['Psicologia ocupacional', 'Voz ocupacional', 'Visiometria ocupacional', 'Consulta Medica ocupacional'];
            $tipoCitaOtro = ['Consulta Medica ocupacional'];
            $cupO = [2013, 2358, 2344, 71];

            if ($request['especialidad']['nombre'] === "Examenes ocupacionales periódicos" || $request['especialidad']['nombre'] === "Examenes ocupacionales egreso" || $request['especialidad']['nombre'] === "Examenes ocupacionales ingreso") {
                // return $request['agenda']['consultorio']['rep_id'];
                foreach ($tipoCita as $key => $tipo) {
                    $tipo = TipoConsulta::where('nombre', $tipo)->first();
                    $consulta = new Consulta();
                    $consulta->agenda_id = intval($request["agenda"]['id']);
                    $consulta->especialidad_id = $request["especialidad"]["id"];
                    $consulta->cup_id = $cupO[$key];
                    ;
                    $consulta->tipo_consulta_id = $tipo->id;
                    $consulta->rep_id = $request['agenda']['consultorio']['rep_id'];
                    $consulta->cita_id = intval($request["cita"]['id']);
                    $consulta->estado_id = 13;
                    $consulta->afiliado_id = intval($request["paciente"]["id"]);
                    $consulta->user_id = auth()->user()->id;
                    $consulta->save();
                }
                $agenda = Agenda::find($request["agenda"]['id']);
                $agenda->estado_id = 6;
                $agenda->save();
                return ['mensaje' => 'Cita asignada al afiliado con exito!', 'status' => 200, 'id' => $consulta->id];
            } elseif (
                $request['especialidad']['nombre'] === "Examenes ocupacionales post incapacidad" ||
                $request['especialidad']['nombre'] === "Examenes ocupacionales reubicación" ||
                $request['especialidad']['nombre'] === "Examenes ocupacionales para participar en eventos deportivos" ||
                $request['especialidad']['nombre'] === "Examenes ocupacionales para participar en eventos folcloricos"

            ) {
                // return $tipoCitaOtro;
                foreach ($tipoCitaOtro as $key => $tipo) {
                    $tipo = TipoConsulta::where('nombre', $tipo)->first();
                    $consulta = new Consulta();
                    $consulta->agenda_id = intval($request["agenda"]['id']);
                    $consulta->especialidad_id = $request["especialidad"]["id"];
                    $consulta->cup_id = $cupO[$key];
                    $consulta->tipo_consulta_id = $tipo->id;
                    $consulta->cita_id = intval($request["cita"]['id']);
                    $consulta->rep_id = $request['agenda']['consultorio']['rep_id'];
                    $consulta->estado_id = 13;
                    $consulta->afiliado_id = intval($request["paciente"]["id"]);
                    $consulta->user_id = auth()->user()->id;
                    $consulta->save();
                }
                $agenda = Agenda::find($request["agenda"]['id']);
                $agenda->estado_id = 6;
                $agenda->save();
                return ['mensaje' => 'Cita asignada al afiliado con exito!', 'status' => 200, 'id' => $consulta->id];
            } else {
                // return $request;
                $ciclo_vida = '';
                if (intval($request["paciente"]["edad_cumplida"]) <= 5) {
                    $ciclo_vida = 'Primera Infancia (0-5 Años)';
                } else if (intval($request["paciente"]["edad_cumplida"]) >= 6 && intval($request["paciente"]["edad_cumplida"]) <= 11) {
                    $ciclo_vida = 'Infancia (6-11 Años)';
                } else if (intval($request["paciente"]["edad_cumplida"]) >= 12 && intval($request["paciente"]["edad_cumplida"]) <= 17) {
                    $ciclo_vida = 'Adolescencia (12 A 17 Años)';
                } else if (intval($request["paciente"]["edad_cumplida"]) >= 18 && intval($request["paciente"]["edad_cumplida"]) <= 28) {
                    $ciclo_vida = 'Joven (18 A 28 Años)';
                } else if (intval($request["paciente"]["edad_cumplida"]) >= 29 && intval($request["paciente"]["edad_cumplida"]) <= 59) {
                    $ciclo_vida = 'Adulto (29 A 59 Años)';
                } else {
                    $ciclo_vida = 'Vejez (Mayor a 60 Años)';
                }
                $consulta = new Consulta();
                $consulta->fecha_hora_inicio = $request["agenda"]['fecha_inicio'];
                $consulta->fecha_hora_final = $request["agenda"]['fecha_fin'];
                $consulta->agenda_id = $request["agenda"]['id'];
                $consulta->especialidad_id = $request["especialidad"]["id"];
                $consulta->medico_ordena_id = $request["medico"] ? $request["medico"]['id'] : auth()->id();
                $consulta->tipo_consulta_id = $request["cita"]['tipo_consulta_id'];
                $consulta->fecha_solicitada = $request['fecha_solicitada'];
                $consulta->cup_id = $this->calcularCupControl(intval($request["paciente"]["id"]), intval($request["cita"]['id']));
                $consulta->cita_id = $request["cita"]['id'];
                $consulta->ciclo_vida_atencion = $ciclo_vida;
                $consulta->estado_id = 13;
                $consulta->afiliado_id = $request["paciente"]["id"];
                $consulta->user_id = auth()->user()->id;
                $consulta->observacion_agenda = $request["observacion"];
                $consulta->save();

                $demandaInsatisfecha = DemandaInsatisfecha::select('demanda_insatisfechas.id', 'demanda_insatisfechas.especialidad_id', 'demanda_insatisfechas.cita_id', 'demanda_insatisfechas.consulta_id')
                    ->where('afiliado_id', $request['paciente']['id'])
                    ->where('consulta_id', null)
                    ->first();

                if ($demandaInsatisfecha) {
                    if ($request['especialidad']['id'] == $demandaInsatisfecha['especialidad_id'] && $request['cita']['id'] == $demandaInsatisfecha['cita_id']) {
                        $demandaInsatisfecha->update([
                            'consulta_id' => $consulta->id
                        ]);
                    }
                }
                $this->calcularEstadoAgenda($request["agenda"]['id']);

                if (isset($request['servicio_id'])) {
                    // Verificar el tipo de orden
                    if ($request['tipo_orden'] === 'procedimiento') {
                        // Validación y guardado para tipo procedimiento
                        $idcups = OrdenProcedimiento::where('id', $request['servicio_id'])->first();
                        ConsultaOrdenProcedimientos::create([
                            'orden_procedimiento_id' => $request['servicio_id'], // Inserta en orden_procedimiento_id
                            'consulta_id' => $consulta->id,
                            'cantidad_usada' => $request['cantidad_usada'],
                            'user_id' => Auth::user()->id
                        ]);
                        // Actualiza el cup_id en la tabla Consulta
                        $cupOrden = ConsultaOrdenProcedimientos::where('orden_procedimiento_id', $request['servicio_id'])
                            ->where('consulta_id', $consulta->id)->first();
                        Consulta::find($cupOrden->consulta_id)
                            ->update([
                                'cup_id' => intval($idcups->cup_id)
                            ]);

                        // Marcar el OrdenProcedimiento en estado "Usada"
                        // Marcar el OrdenProcedimiento en estado "Usada"
                        $procedimiento = OrdenProcedimiento::where('id', $request['servicio_id'])->first();
                        $procedimiento->cantidad_usada = $request['cantidad_usada'];
                        $procedimiento->cantidad_pendiente = $request['cantidad_pendiente'];
                        $procedimiento->estado_id = $request['cantidad_pendiente'] == 0 ? 54 : 1;
                        if ($request['cantidad_pendiente'] == 0) {
                            $procedimiento->estado_id_gestion_prestador = 58;
                            $procedimiento->fecha_sugerida = $request['fecha_solicitada'];
                            $procedimiento->fecha_solicitada = $request['fecha_solicitada'];
                            $procedimiento->observaciones = $request["observacion"];
                            //                            $procedimiento->responsable =
                        }
                        $procedimiento->save();
                    } elseif ($request['tipo_orden'] === 'codigo_propio') {
                        // Validación y guardado para tipo código propio

                        $idcups = OrdenCodigoPropio::where('id', $request['servicio_id'])->first();


                        ConsultaOrdenProcedimientos::create([
                            'orden_codigo_propio_id' => $request['servicio_id'], // Inserta en orden_codigo_propio_id
                            'consulta_id' => $consulta->id,
                            'cantidad_usada' => $request['cantidad_usada'],
                            'user_id' => Auth::user()->id
                        ]);


                        // Actualiza el cup_id en la tabla Consulta
                        $cupOrden = ConsultaOrdenProcedimientos::where('orden_codigo_propio_id', $request['servicio_id'])
                            ->where('consulta_id', $consulta->id)->first();
                        Consulta::find($cupOrden->consulta_id)
                            ->update([
                                'cup_id' => intval($idcups->codigoPropio->cup_id)
                            ]);

                        // Marcar el OrdenCodigoPropio en estado "Usada"
                        $procedimientoPropio = OrdenCodigoPropio::where('id', $request['servicio_id'])->first();
                        $procedimientoPropio->cantidad_usada = $request['cantidad_usada'];
                        $procedimientoPropio->cantidad_pendiente = $request['cantidad_pendiente'];
                        $procedimientoPropio->estado_id = $request['cantidad_pendiente'] == 0 ? 54 : 1;
                        if ($request['cantidad_pendiente'] == 0) {
                            $procedimientoPropio->estado_id_gestion_prestador = 58;
                            $procedimientoPropio->fecha_sugerida = $request['fecha_solicitada'];
                            $procedimientoPropio->fecha_solicitada = $request['fecha_solicitada'];
                            $procedimientoPropio->observaciones = $request["observacion"];
                        }
                        $procedimientoPropio->save();
                    }
                }



                return ['mensaje' => 'Cita asignada al afiliado con exito!', 'status' => 200, 'id' => $consulta->id];
            }
        } else {
            return ['mensaje' => '¡No está disponible esta cita!', 'status' => 422];
        }
    }

    public function generarConsultaTriage($data)
    {
        DB::beginTransaction();
        try {
            // se obtiene la especialidad
            $especialidad = $this->especialidadRepository->obtenerEspecialidadPorNombre('Medicina General Urgencias');
            // se obtiene la cita por nombre
            $cita = $this->citaRepository->obtenerCitaNombre('Triage');
            // se obtiene el tipo de consulta
            $tipoConsulta = $this->tipoConsultaRepository->obtenerTipoConsultaNobre('Urgencias');
            //se crea la consulta
            $consulta = new Consulta();
            $consulta->finalidad = "Consulta urgencias";
            $consulta->fecha_hora_inicio = date('Y-m-d H:i:s');
            $consulta->afiliado_id = $data['afiliado_id'];
            $consulta->estado_id = 7;
            $consulta->cita_no_programada = 0;
            $consulta->especialidad_id = $especialidad->id;
            $consulta->cita_id = $cita->id;
            $consulta->tipo_consulta_id = $tipoConsulta->id;
            $consulta->medico_ordena_id = auth()->id();
            $consulta->hora_inicio_atendio_consulta = Carbon::now();
            $consulta->admision_urgencia_id = $data['admision_urgencia_id'];
            $consulta->cup_id = 7218;
            $consulta->save();
            $infoConsulta = Consulta::with(['afiliado.tipoDocumento', 'cita', 'cita.especialidad'])->where('id', $consulta->id)->first();
            DB::commit();
            return $infoConsulta;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }


    }

    /**
     * Registra los datos correspondientes a la firma del consentimiento informado de antestesia en la consulta
     * @param array $datosConsentimiento
     * @throws \Exception
     * @return string
     */
    public function firmarConsentimientoAnestesia(array $datosConsentimiento)
    {

        $id = $datosConsentimiento['consulta_id'];

        $consulta = $this->consultaRepository->buscar($id);

        if (!$consulta) {
            throw new Exception('La consulta a la que desea firmarle el consentimiento no está registrada');
        }

        #se actualizan los campos
        if ($datosConsentimiento['aceptacion_consentimiento'] === 'No') {
            $consulta->firma_consentimiento = $datosConsentimiento['firma_disentimiento'];
        } else {
            $consulta->firma_consentimiento = $datosConsentimiento['firma_consentimiento'];
        }
        $consulta->firmante = $datosConsentimiento['firmante'];
        $consulta->firma_acompanante = $datosConsentimiento['firma_acompanante'];
        $consulta->firma_consentimiento_time = now()->toDateTimeString();
        $consulta->nombre_representante = $datosConsentimiento['nombre_acompanante'];
        $consulta->nombre_profesional = $datosConsentimiento['nombre_profesional'];
        $consulta->aceptacion_consentimiento = $datosConsentimiento['aceptacion_consentimiento'];
        $consulta->numero_documento_representante = $datosConsentimiento['numero_documento_representante'];
        $consulta->declaracion_a = $datosConsentimiento['declaracion_a'];
        $consulta->declaracion_b = $datosConsentimiento['declaracion_b'];
        $consulta->save();

        return 'Firmado correctamente';

    }
}
