<?php

namespace App\Http\Modules\Agendas\Services;

use App\Events\NotificacionUsuario;
use App\Http\Modules\Agendas\Models\Agenda;
use App\Http\Modules\Agendas\Models\AgendamientoCirugia;
use App\Http\Modules\Agendas\Models\AgendaUser;
use App\Http\Modules\Agendas\Repositories\AgendaRepository;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Consultorios\Models\Consultorio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AgendaService
{

    protected $agendaReposotory;
    protected $agendaModel;

    public function __construct()
    {
        $this->agendaReposotory = new AgendaRepository();
        $this->agendaModel = new Agenda();
    }

    public function guardar($request)
    {
        foreach ($request["fechas"] as $fecha) {
            $fechaHoraDesde = $fecha . ' ' . $request["horaInicio"];
            $fechaHoraHasta = $fecha . ' ' . $request["horaFinal"];
            $agendaConsultorio = Agenda::where('consultorio_id', $request["consultorio"])
                ->whereIn('estado_id', [11, 12])
                ->where(function ($query) use ($fechaHoraDesde, $fechaHoraHasta) {

                    $query->where(function ($query) use ($fechaHoraDesde, $fechaHoraHasta) {
                        $query->where('fecha_inicio', '>', $fechaHoraDesde)
                            ->where('fecha_inicio', '<', $fechaHoraHasta);
                    })
                        ->orWhere(function ($query) use ($fechaHoraDesde, $fechaHoraHasta) {
                            $query->where('fecha_fin', '>', $fechaHoraDesde)
                                ->where('fecha_fin', '<', $fechaHoraHasta);
                        })
                        ->orWhere(function ($query) use ($fechaHoraDesde, $fechaHoraHasta) {
                            $query->where('fecha_inicio', '<=', $fechaHoraDesde)
                                ->where('fecha_fin', '>=', $fechaHoraHasta);
                        })
                        ->orWhere(function ($query) use ($fechaHoraDesde, $fechaHoraHasta) {
                            $query->where('fecha_inicio', $fechaHoraDesde)
                                ->where('fecha_fin', $fechaHoraHasta);
                        });
                })->first();
            if ($agendaConsultorio) {
                return ['mensaje' => 'Ya hay una agenda en este mismo rango de hora!', 'status' => 422];
            }

            // if($request["cita"]["procedimiento_no_especifico"] == 1){
            $medicoAgenda = Agenda::join('agenda_user as au', 'agendas.id', 'au.agenda_id')
                ->join('users as u', 'au.user_id', 'u.id')
                ->where('au.user_id', $request["medico"])
                ->whereIn('agendas.estado_id', [11, 12])
                ->where(function ($query) use ($fechaHoraDesde, $fechaHoraHasta) {

                    $query->where(function ($query) use ($fechaHoraDesde, $fechaHoraHasta) {
                        $query->where('agendas.fecha_inicio', '>', $fechaHoraDesde)
                            ->where('agendas.fecha_inicio', '<', $fechaHoraHasta);
                    })
                        ->orWhere(function ($query) use ($fechaHoraDesde, $fechaHoraHasta) {
                            $query->where('agendas.fecha_fin', '>', $fechaHoraDesde)
                                ->where('agendas.fecha_fin', '<', $fechaHoraHasta);
                        })
                        ->orWhere(function ($query) use ($fechaHoraDesde, $fechaHoraHasta) {
                            $query->where('agendas.fecha_inicio', '<', $fechaHoraHasta)
                                ->where('agendas.fecha_fin', '>', $fechaHoraDesde);
                        })
                        ->orWhere(function ($query) use ($fechaHoraDesde, $fechaHoraHasta) {
                            $query->where('agendas.fecha_inicio', $fechaHoraHasta)
                                ->where('agendas.fecha_fin', $fechaHoraDesde);
                        });
                })->first();

            if ($medicoAgenda) {
                return ['mensaje' => '¡Médico ocupado!', 'status' => 422];
            }

            // }

        }


        $inicio = new \DateTime($request['horaInicio'] . ":00");
        $fin = new \DateTime($request['horaFinal'] . ":00");
        $diferencia = $inicio->diff($fin);
        $minutos = (60 * $diferencia->h) + $diferencia->i;
        $numeroAgendas = round($minutos / intval($request["cita"]["tiempo_consulta"]) - 1);
        foreach ($request['fechas'] as $fecha) {
            $horaInicial = new \DateTime($fecha . " " . $request['horaInicio'] . ":00");
            $horaFinal = new \DateTime($fecha . " " . $request['horaInicio'] . ":00");
            for ($i = 0; $i <= $numeroAgendas; $i++) {
                $agenda = Agenda::create([
                    'cita_id' => $request["cita"]["id"],
                    'fecha_inicio' => $horaInicial->format("Y-m-d H:i:s"),
                    'fecha_fin' => $horaFinal->modify("+{$request["cita"]["tiempo_consulta"]} minute")->format("Y-m-d H:i:s"),
                    'consultorio_id' => $request['consultorio'],
                    'estado_id' => 11
                ]);
                if ($request["cita"]["procedimiento_no_especifico"] == 1) {
                    $agenda->cantidad = $request['cantidad'];
                    $agenda->save();
                }
                if (!$request["cita"]["procedimiento_no_especifico"]) {
                    if (intval($request["cita"]["tipo_cita_id"]) === 2) {
                        if (isset($request['adicional'])) {
                            foreach ($request["adicional"] as $integrante) {
                                AgendaUser::create([
                                    'user_id' => $integrante["id"],
                                    'agenda_id' => $agenda->id
                                ]);
                            }
                        }
                    }
                    AgendaUser::create([
                        'user_id' => $request["medico"],
                        'agenda_id' => $agenda->id
                    ]);
                    $horaInicial = $horaFinal;
                }
            }
        }
        $usuarioId = $request["medico"];
        $mensaje = 'Se te ha creado una nueva agenda de ' . $request["cita"]["nombre"] . ' para la fecha ' . $horaInicial->format("Y-m-d");
        $titulo = 'Nueva agenda creada';
        $ruta = '/panelMedico/atencion';
        $canal = 'usuario.' . $usuarioId;
        event(new NotificacionUsuario($usuarioId, $mensaje, $canal, $ruta, $titulo));
        return ['mensaje' => 'Agenda generada con exito', 'status' => 200];

    }



    public function reasignarAgendaMedico($request)
    {
        foreach ($request["agendas"] as $agenda) {
            $fechaHoraDesde = $agenda["fecha_inicio"];
            $fechaHoraHasta = $agenda["fecha_fin"];

            $medicoAgenda = Agenda::join('agenda_user as au', 'agendas.id', 'au.agenda_id')
                ->join('users as u', 'au.user_id', 'u.id')
                ->where('au.user_id', $request["medicoReemplazo"])
                ->whereIn('agendas.estado_id', [11, 12])
                ->where(function ($query) use ($fechaHoraDesde, $fechaHoraHasta) {
                    $query->where(function ($query) use ($fechaHoraDesde, $fechaHoraHasta) {
                        $query->where('agendas.fecha_inicio', '>', $fechaHoraDesde)
                            ->where('agendas.fecha_inicio', '<', $fechaHoraHasta);
                    })->orWhere(function ($query) use ($fechaHoraDesde, $fechaHoraHasta) {
                        $query->where('agendas.fecha_fin', '>', $fechaHoraDesde)
                            ->where('agendas.fecha_fin', '<', $fechaHoraHasta);
                    })->orWhere(function ($query) use ($fechaHoraDesde, $fechaHoraHasta) {
                        $query->where('agendas.fecha_inicio', '<', $fechaHoraHasta)
                            ->where('agendas.fecha_fin', '>', $fechaHoraDesde);
                    })->orWhere(function ($query) use ($fechaHoraDesde, $fechaHoraHasta) {
                        $query->where('agendas.fecha_inicio', $fechaHoraHasta)
                            ->where('agendas.fecha_fin', $fechaHoraDesde);
                    });
                })
                ->first();

            if ($medicoAgenda) {
                return ['mensaje' => '¡Médico ocupado! (' . $fechaHoraDesde . ' / ' . $fechaHoraHasta . ')', 'status' => 422];
            }
        }

        foreach ($request["agendas"] as $agenda) {
            AgendaUser::where('agenda_id', $agenda["id"])
                ->where('user_id', $request["medico"])
                ->update(["user_id" => $request["medicoReemplazo"]]);

            $consulta = Consulta::where('agenda_id', $agenda["id"])->first();

            if ($consulta) {
                $consulta->update(["medico_ordena_id" => $request["medicoReemplazo"]]);
            }
        }

        return ['mensaje' => '¡Reasignación realizada!', 'status' => 200];
    }


    public function cambioAgenda($cambioAgenda)
    {
        if ($cambioAgenda->accion == 'bloquear') {
            return $this->agendaModel->where('agendas.id', $cambioAgenda->agenda_id)->update([
                'estado_id' => 12
            ]);
        }
        if ($cambioAgenda->accion == 'eliminar') {
            return $this->agendaModel->where('agendas.id', $cambioAgenda->agenda_id)->update([
                'estado_id' => 2
            ]);
        }
        if ($cambioAgenda->accion == 'eliminarBloque') {
            $agendaActual = DB::table('agendas')
                ->select('created_at', 'fecha_inicio')
                ->where('id', $cambioAgenda->agenda_id)
                ->first();

            if ($agendaActual) {
                $agendasConMismoCreatedAtYFechaInicio = DB::table('agendas')
                    ->where('created_at', $agendaActual->created_at)
                    ->whereDate('fecha_inicio', $agendaActual->fecha_inicio)
                    ->whereIn('estado_id', [11, 12])
                    ->pluck('id');

                $agendasParaActualizar = DB::table('agenda_user')
                    ->whereIn('agenda_id', $agendasConMismoCreatedAtYFechaInicio)
                    ->pluck('agenda_id');

                DB::table('agendas')
                    ->whereIn('id', $agendasParaActualizar)
                    ->whereIn('estado_id', [11, 12])
                    ->update(['estado_id' => 2]);
            }
        }

        if ($cambioAgenda->accion == 'bloquearBloque') {
            $agendaActual = DB::table('agendas')
                ->select('created_at', 'fecha_inicio')
                ->where('id', $cambioAgenda->agenda_id)
                ->first();

            if ($agendaActual) {
                $agendasConMismoCreatedAtYFechaInicio = DB::table('agendas')
                    ->where('created_at', $agendaActual->created_at)
                    ->whereDate('fecha_inicio', $agendaActual->fecha_inicio)
                    ->where('estado_id', 11)
                    ->pluck('id');

                $agendasParaActualizar = DB::table('agenda_user')
                    ->whereIn('agenda_id', $agendasConMismoCreatedAtYFechaInicio)
                    ->pluck('agenda_id');

                DB::table('agendas')
                    ->whereIn('id', $agendasParaActualizar)
                    ->where('estado_id', 11)
                    ->update(['estado_id' => 12]);
            }
        }

        if ($cambioAgenda->accion == 'desbloquear') {
            return $this->agendaModel->where('agendas.id', $cambioAgenda->agenda_id)->update([
                'estado_id' => 11
            ]);
        }

        if ($cambioAgenda->accion == 'desbloquearBloque') {
            $agendaActual = DB::table('agendas')
                ->select('created_at', 'fecha_inicio')
                ->where('id', $cambioAgenda->agenda_id)
                ->first();

            if ($agendaActual) {
                // Obtener todas las agendas del mismo bloque que estén actualmente bloqueadas estado_id = 12
                $agendasConMismoCreatedAtYFechaInicio = DB::table('agendas')
                    ->where('created_at', $agendaActual->created_at)
                    ->whereDate('fecha_inicio', $agendaActual->fecha_inicio)
                    ->where('estado_id', 12)
                    ->pluck('id');

                // Verificar cuáles de esas agendas están en agenda_user
                $agendasParaActualizar = DB::table('agenda_user')
                    ->whereIn('agenda_id', $agendasConMismoCreatedAtYFechaInicio)
                    ->pluck('agenda_id');

                // Actualizar todas las agendas encontradas a estado_id = 11 disponible
                DB::table('agendas')
                    ->whereIn('id', $agendasParaActualizar)
                    ->where('estado_id', 12)
                    ->update(['estado_id' => 11]);
            }
        }
    }

    public function actualizarCita($request)
    {
        DB::beginTransaction();
        try {
            $this->agendaModel->where('agendas.id', $request['agenda_id'])->update([
                'cita_id' => $request['cita_id']
            ]);

            // Buscar la consulta asociada
            $consulta = Consulta::where('agenda_id', $request['agenda_id'])->first();

            // Si existe una consulta asociada, actualizarla
            if ($consulta) {
                $consulta->update([
                    'cita_id' => $request['cita_id']
                ]);
            }
            DB::commit();
            return true;
        } catch (\Exception $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function listarCitas($tipo = 'telemedicina', $estados = [13, 30])
    {
        $citas = Consulta::select([
            'consultas.id as id',
            'agendas.id as historia',
            DB::raw("agendas.fecha_inicio::date as fecha"),
            DB::raw("agendas.fecha_inicio::time as hora"),
            'citas.tiempo_consulta as duracion_cita',
            'especialidades.nombre as especialidad',
            'reps.nombre as nombreSede',
            'reps.direccion as direccionSede',
            DB::raw("CONCAT(operadores.nombre,' ',operadores.apellido) as nombre_medico"),
            DB::raw("'TELEMEDICINA' observacion"),
            'consultas.estado_id as estado_cita',
            'users.email as email_medico',
            DB::raw("'telemedicina@sumimedical.com' email_salida"),
            'consultas.updated_at as fecha_modificacion',
            DB::raw("concat(afiliados.primer_nombre,' ',afiliados.segundo_nombre,' ',afiliados.primer_apellido,' ',afiliados.segundo_apellido) as nombre_paciente"),
            'afiliados.correo1 as email_paciente',
            'afiliados.numero_documento as documento_paciente',
            'afiliados.celular1 as numero'

        ])
            ->join('afiliados', 'afiliados.id', 'consultas.afiliado_id')
            ->join('agendas', 'agendas.id', 'consultas.agenda_id')
            ->join('agenda_user', 'agenda_user.agenda_id', 'agendas.id')
            ->join('operadores', 'operadores.user_id', 'agenda_user.user_id')
            ->join('users', 'users.id', 'agenda_user.user_id')
            ->join('citas', 'citas.id', 'agendas.cita_id')
            ->join('especialidades', 'especialidades.id', 'citas.especialidade_id')
            ->join('consultorios', 'consultorios.id', 'agendas.consultorio_id')
            ->join('reps', 'reps.id', 'consultorios.rep_id')
            ->whereModalidad($tipo)
            ->without(['afiliado', 'estado', 'tipoConsulta'])
            ->whereIn('consultas.estado_id', $estados)
            ->whereTipoDeConsulta($tipo)->get();

        return $citas ? $citas : false;
    }

    public function formatoParaMeet($data)
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

    /**
     * Da un formato a la duracion de las citas (podria ser mas general pero se hace para avanzar)
     * @param $minutos
     * @return String
     */
    private function formatoHora($minutos)
    {
        $objeto = (object) ['horas' => 0, 'minutos' => 0];

        $objeto->horas = floor($minutos / 60);
        $objeto->minutos = $minutos - ($objeto->horas * 60);

        return '0' . $objeto->horas . ':' . ($objeto->minutos < 10 ? '0' . $objeto->minutos : $objeto->minutos) . ':00';
    }

    /**
     * determinar estado
     * @param int $estado
     * @return String
     */
    public function determinarEstado($estado)
    {
        switch ($estado) {
            case 13:
                return 'P';
                break;
            case 30:
                return 'C';
                break;
            default:
                return 'Sin estado';
                break;
        }
    }

    /**
     * obtiene una agenda en particular
     */
    public function getAgenda($agenda_id)
    {
        return Agenda::where('id', $agenda_id)
            ->without(['medicos'])
            ->with([
                'cita' => function ($query) {
                    $query->without(['modalidad']);
                },
                'cita.especialidad',
                'consultorio.rep.municipio',
                'cita.tipoCita',
                'consultas' => function ($query) {
                    $query->withTrashed()
                        ->with([
                            'afiliado' => function ($query) {
                                $query->select('id', 'numero_documento', 'primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido');
                            }
                        ]);
                },
                'consultorio.rep' => function ($query) {
                    $query->without(['consultorios', 'prestadores']);
                }
            ])
            ->first();
    }

    public function guardarAgendaCirugia($request)
    {
        $agendamiento = new AgendamientoCirugia();
        $agendamiento->afiliado_id = $request['afiliado_id']['id'];
        $agendamiento->clase = $request['clase'];
        // $agendamiento->cup_id = $request['cup_id']['id'];
        $agendamiento->reps_id = $request['rep_id']['id'];
        $agendamiento->consultorio_id = $request['quirofano_id']['id'];
        $agendamiento->fecha = $request['fecha_cirugia'];
        $agendamiento->hora_inicio_estimada = $request['hora_inicio_estimada'];
        $agendamiento->hora_fin_estimada = $request['hora_fin_estimada'];
        $agendamiento->color_evento = $request['colorSeleccionado'];
        $agendamiento->tipo_anestesia = $request['tipo_anestesia'];
        $agendamiento->orden_id = $request['orden_id'];
        if ($agendamiento->tipo_anestesia !== 'LOCAL') {
            $agendamiento->anestesiologo = $request['anestesiologo']['id'];
            $agendamiento->fecha_aval_cirugia = $request['fecha_aval_cirugia'];
            $agendamiento->aval_cirugia = $request['aval_cirugia'];
            $agendamiento->observacion_negacion_aval_cirugia = $request['observacion_negacion_aval_cirugia'];
        }
        $agendamiento->cirujano = $request['cirujano']['user_id'];
        $agendamiento->especialidad_cirujano = $request['especialidad_cirujano'];
        $agendamiento->usuario_crea = Auth::id();
        $agendamiento->estado_id = 1;
        $agendamiento->save();
        $agendamiento->cupsAgenda()->sync($request['cup_id']);
        return $agendamiento;
    }

    public function historicoPorCategorias($request)
    {
        $agendamiento = $this->agendaReposotory->historicoAgendasCirugia($request);
        $consultorios = $this->agendaReposotory->quirofanosSede($request['rep_id']);

        $datos = [
            'registros' => $agendamiento,
            'categorias' => array_column($consultorios->toArray(), 'nombre')
        ];
        return $datos;
    }

    public function trasladarConsultorios(array $data): array
    {
        $consultorioDestino = Consultorio::findOrFail($data['consultorio_destino']);

        $resultados = [];

        return DB::transaction(function () use ($data, $consultorioDestino, &$resultados) {

            foreach ($data['agendas'] as $agendaId) {

                $agenda = Agenda::findOrFail($agendaId);
                $consultorioOrigen = $agenda->consultorio;

                if ($consultorioDestino->cantidad_paciente < $consultorioOrigen->cantidad_paciente) {
                    throw ValidationException::withMessages([
                        'consultorio_destino' => "El consultorio destino tiene menor capacidad ({$consultorioDestino->cantidad_paciente}) que el origen ({$consultorioOrigen->cantidad_paciente}) para la agenda que inicia a las {$agenda->fecha_inicio}."
                    ]);
                }

                $ocupadas = Agenda::query()
                    ->where('consultorio_id', $consultorioDestino->id)
                    ->where('estado_id', 11)
                    ->where(function ($q) use ($agenda) {
                        $q->whereBetween('fecha_inicio', [$agenda->fecha_inicio, $agenda->fecha_fin])
                            ->orWhereBetween('fecha_fin', [$agenda->fecha_inicio, $agenda->fecha_fin])
                            ->orWhere(function ($query) use ($agenda) {
                                $query->where('fecha_inicio', '<=', $agenda->fecha_inicio)
                                    ->where('fecha_fin', '>=', $agenda->fecha_fin);
                            });
                    })
                    ->exists();

                if ($ocupadas) {
                    throw ValidationException::withMessages([
                        'consultorio_destino' => "El consultorio destino ya tiene ocupada parte del rango de horarios de la agenda. {$agenda->fecha_inicio} - {$agenda->fecha_fin}."
                    ]);
                }

                $agenda->update([
                    'consultorio_id' => $consultorioDestino->id,
                ]);

                DB::table('cambio_agendas')->insert([
                    'agenda_id' => $agenda->id,
                    'user_id' => Auth::id(),
                    'accion' => 'Traslado de consultorio',
                    'motivo' => $data['motivo'] ?? null,
                    'consultorio_origen_id' => $consultorioOrigen->id,
                    'consultorio_destino_id' => $consultorioDestino->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $resultados[] = [
                    'agenda_id' => $agenda->id,
                    'origen' => $consultorioOrigen->id,
                    'destino' => $consultorioDestino->id,
                    'accion' => 'Traslado de consultorio',
                    'motivo' => $data['motivo'] ?? '',
                ];
            }

            return $resultados;
        });
    }
}
