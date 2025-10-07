<?php

namespace App\Http\Modules\Consultas\Repositories;

use App\Http\Modules\Agendas\Models\Agenda;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Cie10\Models\Cie10;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Consultas\Models\ConsultaOrdenProcedimientos;
use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Especialidades\Models\Especialidade;
use App\Http\Modules\Evoluciones\Models\Evolucion;
use App\Http\Modules\GestionOrdenPrestador\Models\GestionOrdenPrestador;
use App\Http\Modules\Historia\AntecedentesPersonales\Models\AntecedentePersonale;
use App\Http\Modules\Historia\Models\HistoriaClinica;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Ordenamiento\Models\OrdenCodigoPropio;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Modules\Recomendaciones\Models\Recomendaciones;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Modules\Cie10Afiliado\Models\Cie10Afiliado;
use App\Http\Modules\CodigoPropios\Models\CodigoPropio;
use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;
use App\http\Modules\Referencia\Models\Referencia;
use App\Http\Modules\TipoConsultas\Models\TipoConsulta;

class ConsultaRepository extends RepositoryBase
{
    public function __construct(
        protected Consulta $consultaModel,
        protected Operadore $operador,
        protected Evolucion $evolucion,
        protected Recomendaciones $recomendaciones,
    ) {
        parent::__construct($this->consultaModel);
    }

    // public function citasIndividales($medico_id, $estados = [])
    // {
    //     return Consulta::whereHas('agenda', function (Builder $query) use ($medico_id) {
    //         $query->whereHas('users',function (Builder $query) use ($medico_id) {
    //             return $query->where('user_id', $medico_id);
    //         });
    //     })->whereHas('agenda', function ($query) {
    //         $query->whereNotIn('cita_id',[2]);
    //     })
    //     ->whereEstado([13,7,14,9,8])
    //     ->with(['afiliado','afiliado.departamento_residencia','afiliado.municipio_residencia','agenda' => function ($query) {
    //         $query->with('cita');
    //     },'agenda.consultorio.rep','cita','cita.especialidad'])
    //     ->whereDate('consultas.fecha_hora_inicio', Carbon::now())
    //     ->orderBy('consultas.fecha_hora_inicio', 'Asc')
    //     ->get();
    // }


    /**
     * citasIndividales
     *Funcion que trae los citas individuales agendadas de cada medico
     * @param mixed $medico_id
     * @param mixed $estados
     * @return
     */
    public function citasIndividales($medico_id, $estados = [])
    {
        return Consulta::select([
            'consultas.id',
            'consultas.fecha_hora_inicio',
            'consultas.tiempo_consulta',
            'consultas.afiliado_id',
            'consultas.agenda_id',
            'consultas.cita_id',
            'consultas.estado_id',
            'reps.nombre as nombreRep',
            'citas.nombre as actividad'
        ])
            ->join('agendas', 'consultas.agenda_id', 'agendas.id')
            ->join('agenda_user', 'agendas.id', 'agenda_user.agenda_id')
            ->join('users', 'agenda_user.user_id', 'users.id')
            ->join('consultorios', 'agendas.consultorio_id', 'consultorios.id')
            ->join('reps', 'consultorios.rep_id', 'reps.id')
            ->join('citas', 'agendas.cita_id', 'citas.id')
            ->where('users.id', $medico_id)
            ->with('afiliado.tipoDocumento')
            ->whereNotIn('agendas.cita_id', [2])
            ->whereIn('consultas.estado_id', [7, 14, 9, 8, 13, 59, 67])
            ->whereDate('consultas.fecha_hora_inicio', Carbon::now())
            ->orderBy('consultas.fecha_hora_inicio', 'Asc')
            ->with([
                'agenda',
                'cita' => function ($query) {
                    $query->with('especialidad');
                }
            ])
            ->get();
    }

    public function citasGrupales($medico_id, $id)
    {
        return Consulta::whereHas('agenda', function (Builder $query) use ($medico_id) {
            $query->whereHas('users', function (Builder $query) use ($medico_id) {
                return $query->where('user_id', $medico_id);
            });
        })->whereHas('agenda', function ($query) use ($id) {
            $query->where('id', $id);
        })->whereEstado([13, 7])
            ->whereHas('cita', function ($query) {
                $query->where('tipo_cita_id', 2);
            })->with([
                    'afiliado.tipoDocumento',
                    'agenda' => function ($query) {
                        $query->with('cita.especialidad');
                    },
                    'agenda.consultorio.rep',
                    'cita',
                    'cita.especialidad'
                ])
            ->whereDate('consultas.fecha_hora_inicio', Carbon::now())
            ->get();
    }

    public function citasAgrupadas($medico_id)
    {
        return Agenda::whereHas('users', function (Builder $query) use ($medico_id) {
            $query->where('user_id', $medico_id);
        })
            ->whereHas('cita', function ($query) {
                $query->where('tipo_cita_id', 2);
            })
            ->whereHas('consultas', function ($query) {
                $query->whereIn('estado_id', [13, 7])
                    ->whereDate('fecha_hora_inicio', Carbon::now());
            })
            ->with(['cita.especialidad'])
            ->with('consultorio')
            ->get();
    }

    public function guardarConsultaParaTeleapoyo($id_afiliado)
    {
        return $this->consultaModel->create([
            'finalidad' => 'Teleapoyo',
            'afiliado_id' => $id_afiliado,
            'medico_ordena_id' => auth()->user()->id,
            'tipo_consulta_id' => 84
        ]);
    }

    public function consulta($consulta_id)
    {
        return $this->consultaModel
            ->with([
                'afiliado' => function ($query) {
                    $query->with(['ips:id,nombre', 'municipio_atencion:id,nombre', 'departamento_atencion:id,nombre', 'entidad:id,nombre', 'tipoDocumento', 'tipoAfiliado:id,nombre']);
                }
            ])
            ->find($consulta_id);
    }


    public function contadorConsultaPendientes($afiliado_id)
    {
        return $this->consultaModel::where('afiliado_id', $afiliado_id)
            ->whereNull('finalidad')
            ->where('cita_no_programada', '!=', true)
            ->whereIn('estado_id', [13, 14, 10])
            ->count();
    }

    public function contadorConsultas()
    {
        return $this->consultaModel::where('especialidad_id', '!=', [60, 61, 62, 63, 64, null])
            ->whereHas('agenda', function ($query) {
                $query->whereNotIn('cita_id', [2]);
            })
            ->whereHas('agenda', function (Builder $query) {
                $query->whereHas('users', function (Builder $query) {
                    return $query->where('user_id', Auth::id());
                });
            })
            ->leftJoin('agenda_user', 'consultas.agenda_id', 'agenda_user.agenda_id')
            ->whereDate('consultas.fecha_hora_inicio', Carbon::now())
            ->where('agenda_user.user_id', Auth::id())
            ->count();
    }

    public function contadorOcupacional()
    {
        return $this->consultaModel::join('agendas', 'consultas.agenda_id', 'agendas.id')
            ->leftJoin('agenda_user', 'consultas.agenda_id', 'agenda_user.agenda_id')
            ->whereIn('tipo_consulta_id', [13, 14, 15, 16])
            ->whereDate('agendas.fecha_inicio', Carbon::now())
            ->where('agenda_user.user_id', Auth::id())
            ->count();
    }

    public function contadorConsultaNoProgramada()
    {
        return $this->consultaModel::where('tipo_consulta_id', 2)
            ->where('cita_no_programada', 1)
            ->where('medico_ordena_id', Auth::id())
            ->whereDate('created_at', Carbon::now())
            ->count();
    }

    public function citasOcupacionales($medico_id)
    {
        // $empleado = Empleado::select('especialidades.nombre')
        // ->join('especialidades', 'especialidades.id', 'empleados.especialidad_id')
        // ->where('user_id', $medico_id)->first();
        $especialidades = User::select(['e.nombre', 'e.id as especialidad_id'])
            ->join('especialidade_user as eu', 'eu.user_id', 'users.id')
            ->join('especialidades as e', 'e.id', 'eu.especialidade_id')
            ->where('user_id', $medico_id)->get();
        return Consulta::select(
            'consultas.id',
            'af.primer_nombre',
            'td.nombre as tipo_documento',
            'af.numero_documento',
            'af.sexo',
            'af.edad_cumplida',
            'r2.nombre as SEDE',
            'tc.nombre as ACTIVIDAD',
            'es.nombre as especialidad',
            'consultas.id as id_CONSULTA',
            'a.id as id_AGENDA',
            'citas.id as cita_id',
            'est.id as estado_consulta',
            'e.primer_nombre as nombre_USUARIO',
        )->selectRaw("CONCAT(af.primer_nombre,' ',af.primer_apellido,' ',af.segundo_nombre,' ',af.segundo_apellido) as nombre_completo")
            ->join('afiliados as af', 'consultas.afiliado_id', 'af.id')
            ->join('tipo_documentos as td', 'td.id', 'af.tipo_documento')
            ->join('agendas as a', 'a.id', 'consultas.agenda_id')
            ->join('agenda_user as au', 'a.id', 'au.agenda_id')
            ->join('consultorios as c2', 'c2.id', 'a.consultorio_id')
            ->join('estados', 'consultas.estado_id', 'estados.id')
            ->join('reps as r2', 'r2.id', 'c2.rep_id')
            ->join('especialidades as es', 'es.id', 'consultas.especialidad_id')
            ->join('tipo_consultas as tc', 'tc.id', 'consultas.tipo_consulta_id')
            ->join('empleados as e', 'au.user_id', 'e.user_id')
            ->join('estados as est', 'consultas.estado_id', 'est.id')
            ->join('citas', 'a.cita_id', 'citas.id')
            ->whereIn('consultas.especialidad_id', [60, 61, 62, 63, 64, 69, 70])
            ->whereDate('a.fecha_inicio', Carbon::now())
            ->where('au.user_id', $medico_id)
            ->get();
    }

    public function crear($data)
    {
        return $this->consultaModel->create($data);
    }

    public function aplicacionesPendientes($data)
    {
        $orden = $this->consultaModel->select('consultas.id', 'o.paginacion', 'o.nombre_esquema', 'consultas.afiliado_id')->join('ordenes as o', 'o.consulta_id', 'consultas.id')
            ->with([
                'ordenes' => function ($query) {
                    $query->select([
                        'ordenes.id',
                        'ordenes.consulta_id',
                        'ordenes.paginacion',
                        'ordenes.dia',
                        'ordenes.estado_id',
                        'e.Nombre as estado',
                        'ordenes.fecha_agendamiento',
                    ])
                        ->join('estados as e', 'e.id', 'ordenes.estado_id')
                        // ->join('detaarticulordenes as da', 'da.Orden_id', 'ordenes.id')
                        ->where(function ($q) {
                            $q->where('ordenes.estado_id', 1)
                                ->whereNotNull('ordenes.nombre_esquema')
                                ->where('ordenes.tipo_orden_id', 3)
                                ->WhereNull('ordenes.fecha_agendamiento');
                        })
                        ->distinct()
                        ->get();
                },
                'ordenes.articulos' => function ($query) {
                    $query->select(
                        'orden_articulos.id',
                        'orden_articulos.orden_id',
                        'orden_articulos.codesumi_id',
                        'auditorias.created_at as fechaAutorizacion',
                        'auditorias.observaciones as nota_autorizacion',
                        'orden_articulos.created_at as FechaOrdenamiento',
                        'orden_articulos.dosis',
                        'orden_articulos.frecuencia',
                        'orden_articulos.unidad_tiempo',
                        'orden_articulos.duracion',
                        'orden_articulos.cantidad_mensual',
                        'orden_articulos.meses',
                        'orden_articulos.observacion',
                        'orden_articulos.cantidad_medico',
                        'orden_articulos.fecha_vigencia',
                        'orden_articulos.estado_id',
                        //         'detaarticulordens.notaFarmacia',
                    )
                        ->leftjoin('auditorias', 'auditorias.orden_articulo_id', 'orden_articulos.id')
                        ->get();
                }
            ])
            ->where('o.tipo_orden_id', 3)
            ->whereNotNull('o.nombre_esquema')
            ->WhereNull('o.fecha_agendamiento')
            ->where('o.estado_id', 1)
            ->groupBy('consultas.id', 'o.paginacion', 'o.nombre_esquema', 'consultas.afiliado_id');
        return $data->page ? $orden->paginate($data->cant) : $orden->get();
    }

    public function crearConsultaContingencia($data)
    {
        return $this->consultaModel->create([
            'finalidad' => 'Cargue historia contingencia',
            'afiliado_id' => $data['afiliado_id'],
            'fecha_hora_inicio' => $data['fecha_hora_inicio'],
            'estado_id' => 9,
            'medico_ordena_id' => $data['medico_ordena_id'],
            'tipo_consulta_id' => 86,
            'rep_id' => $data['rep_id'] ?? null,
            'cup_id' => $data['cup_id'] ?? null,
        ]);
    }

    public function inasistir($data)
    {
        $consulta = $this->consultaModel::find($data['consulta']);
        $consulta->estado_id = 8;
        $consulta->motivo_inadecuacion = $data['motivo_inadecuacion'];
        $consulta->save();
        $this->actualizarEstadoGestion($consulta->id, 8);

        $agenda = Agenda::find($consulta->agenda_id);
        $agenda->estado_id = 8;
        $agenda->save();

        return "Consulta inasistida!";
    }

    public function enconsulta($consultaId)
    {
        $consulta = $this->consultaModel::find($consultaId);
        $consulta->estado_id = 7;
        $consulta->hora_inicio_atendio_consulta = Carbon::now();
        $consulta->save();
        HistoriaClinica::create(['consulta_id' => $consultaId]);
        return "Consulta actualizada!";
    }

    public function actualizarTiempo($data)
    {
        // return $data;
        $consulta = $this->consultaModel::find($data['consulta_id']);
        $consulta->segundos = $data['segundos'];
        $consulta->tiempo_consulta = $data['tiempo_consulta'];
        $consulta->save();
        return "Consulta guardada!";
    }

    public function validacionHistoria($data)
    {
        $personales = AntecedentePersonale::whereHas('consulta', function (Builder $query) use ($data) {
            return $query->where('afiliado_id', $data['afiliado']);
        })->get();


        return (object) [
            'personales' => $personales
        ];
    }

    /**
     * Lista las consultas sin finalizar desde el día anterior hacia atrás.
     * Si se proporciona un número de documento, filtra las consultas por este.
     *
     * @param object $data (Campos del filtro)
     * @return Collection
     * @author Thomas Restrepo
     */
    public function consultasSinFinalizar($data)
    {
        // Extraer número de documento del afiliado
        $documentoAfiliado = $data->numeroDocumento;

        // Obtener el ID del médico autenticado
        $medico_id = auth()->user()->id;

        // Construcción del query
        $consultaQuery = Consulta::select([
            'consultas.id',
            'consultas.fecha_hora_inicio',
            'consultas.tiempo_consulta',
            'consultas.afiliado_id',
            'consultas.agenda_id',
            'consultas.cita_id',
            'consultas.estado_id',
            'reps.nombre as nombreRep',
            'citas.nombre as actividad'
        ])
            ->join('agendas', 'consultas.agenda_id', 'agendas.id')
            ->join('agenda_user', 'agendas.id', 'agenda_user.agenda_id')
            ->join('users', 'agenda_user.user_id', 'users.id')
            ->join('consultorios', 'agendas.consultorio_id', 'consultorios.id')
            ->join('reps', 'consultorios.rep_id', 'reps.id')
            ->join('citas', 'agendas.cita_id', 'citas.id')
            ->where('users.id', $medico_id)
            ->with('afiliado.tipoDocumento')
            ->whereNotIn('agendas.cita_id', [2]) // Excluir Atencion Prioritaria
            ->whereIn('consultas.estado_id', [7, 49]) // Filtra por estados EN CONSULTA y HISTORIA CLINICA NO FINALIZADA
            ->whereDate('consultas.fecha_hora_inicio', '<', Carbon::today());

        // Filtrar por número de documento si está presente
        if (isset($documentoAfiliado) && !empty($documentoAfiliado)) {
            $consultaQuery->whereHas('afiliado', function ($query) use ($documentoAfiliado) {
                $query->where('numero_documento', $documentoAfiliado);
            });
        }

        return $consultaQuery
            ->orderBy('consultas.fecha_hora_inicio', 'Asc')
            ->with([
                'agenda',
                'cita' => function ($query) {
                    $query->with('especialidad');
                }
            ])
            ->get();
    }

    public function detallesOrdenConsulta($consultaActivaId)
    {
        // Buscar la consulta activa en la tabla ConsultaOrdenProcedimientos
        $consultaActiva = ConsultaOrdenProcedimientos::select(
            'orden_codigo_propio_id',
            'cantidad_usada',
            'orden_procedimiento_id',
            'consulta_id',
            'operadores.nombre'
        )
            ->leftjoin('users', 'users.id', 'consulta_orden_procedimientos.user_id')
            ->leftjoin('operadores', 'operadores.user_id', 'users.id')
            ->where('consulta_id', $consultaActivaId)
            ->first();

        if (!$consultaActiva) {
            return null; // Retornar null si no se encuentra la consulta
        }

        $detallesOrden = null;

        // Si es un orden procedimiento
        if (!is_null($consultaActiva->orden_procedimiento_id)) {
            $detallesOrden = OrdenProcedimiento::with('cup')
                ->where('id', $consultaActiva->orden_procedimiento_id)
                ->first();

            // Mapear la información para devolver siempre el mismo formato
            return [
                'id' => $detallesOrden->id,
                'orden_id' => $detallesOrden->orden_id,
                'cup_codigo' => $detallesOrden->cup->codigo,
                'cup_nombre' => $detallesOrden->cup->nombre,
                'tipo' => 'Procedimiento',
                'observacion' => $detallesOrden->observacion,
                'user' => $consultaActiva->nombre,
                'cantidad' => $consultaActiva->cantidad_usada,
            ];

            // Si es un orden de código propio
        } elseif (!is_null($consultaActiva->orden_codigo_propio_id)) {
            $detallesOrden = OrdenCodigoPropio::with('codigoPropio.cup')
                ->where('id', $consultaActiva->orden_codigo_propio_id)
                ->first();

            // Mapear la información para devolver siempre el mismo formato
            return [
                'id' => $detallesOrden->id,
                'orden_id' => $detallesOrden->orden_id,
                'cup_codigo' => $detallesOrden->codigoPropio->cup->codigo,
                'cup_nombre' => $detallesOrden->codigoPropio->cup->nombre,
                'tipo' => 'Otros Servicios',
                'observacion' => $detallesOrden->observacion,
                'user' => $consultaActiva->nombre,
                'cantidad' => $consultaActiva->cantidad_usada,
            ];
        }

        return null;
    }


    /**
     * Lista las consultas NO PROGRAMADAS sin finalizar desde el día anterior hacia atrás.
     * Si se proporciona un número de documento, filtra las consultas por este.
     *
     * @param object $data (Campos del filtro)
     * @return Collection
     * @author Thomas Restrepo
     */
    public function noProgramadasSinFinalizar($data)
    {
        // Extraer número de documento del afiliado
        $documentoAfiliado = $data->numeroDocumento;

        // Obtener el ID del médico autenticado
        $medico_id = auth()->user()->id;

        // Construcción del query
        $consultaQuery = Consulta::select([
            'consultas.id',
            'consultas.fecha_hora_inicio',
            'consultas.tiempo_consulta',
            'consultas.afiliado_id',
            'consultas.agenda_id',
            'consultas.cita_id',
            'consultas.estado_id',
            'reps.nombre as nombreRep',
            // 'citas.nombre as actividad'
        ])
            ->join('reps', 'consultas.rep_id', 'reps.id')
            ->where('consultas.medico_ordena_id', $medico_id)
            ->with('afiliado.tipoDocumento')
            ->whereIn('consultas.estado_id', [7, 49]) // Filtra por estados EN CONSULTA y HISTORIA CLINICA NO FINALIZADA
            ->whereDate('consultas.fecha_hora_inicio', '<', Carbon::today());

        // Filtrar por número de documento si está presente
        if (isset($documentoAfiliado) && !empty($documentoAfiliado)) {
            $consultaQuery->whereHas('afiliado', function ($query) use ($documentoAfiliado) {
                $query->where('numero_documento', $documentoAfiliado);
            });
        }

        return $consultaQuery
            ->orderBy('consultas.fecha_hora_inicio', 'Asc')
            ->with([
                'cita' => function ($query) {
                    $query->with('especialidad');
                }
            ])
            ->get();
    }

    /**
     * lista las consultas segun el afiliado validando documento y tipo de documento
     */
    public function listarPorTipoYDocumento($documento, $tipo_documento, $fecha_inicial, $fecha_final, $tipo_historia, $especialidades, $medico = null)
    {
        return Consulta::whereHas('afiliado', function ($query) use ($documento, $tipo_documento) {
            $query->where('numero_documento', $documento)
                ->where('tipo_documento', $tipo_documento);
        })
            ->whereNotIn('tipo_consulta_id', [1, 13, 14, 15, 16, 84])
            ->whereFechaConsulta($fecha_inicial, $fecha_final)
            ->whereTipoHistoria($tipo_historia)
            ->whereEspecialidades($especialidades)
            ->whereMedicoOrdenaId($medico)
            ->with([
                'sistemaRespiratorio',
                'medicoOrdena.especialidades',
                'HistoriaClinica.finalidadConsulta',
                'HistoriaClinica.causaConsulta',
                'resultadoLaboratorios.user.operador',
                'odontogramaNuevo',
                'remision',
                'gestanteGinecologico',
                'whooley',
                'gad2',
                'agenda',
                'agenda.consultorio.rep',
                'afiliado.tipoDocumento',
                'cita',
                'cita.categorias',
                'cita.categorias.campos',
                'historia',
                'historia.clinica',
                'medicoOrdena.operador',
                'HistoriaClinica.NotaAclaratoria',
                'antecedentePersonales',
                'antecedentesFarmacologicos.medicamento.codesumi',
                'antecedentesFamiliares',
                'antecedenteTransfucionales',
                'vacunacion',
                'antecedenteQuirurgicos',
                'antecedenteHospitalarios',
                'antecedentesSexuales',
                'antecedenteEcomapa',
                'antecedenteFamiliograma',
                'resultadoLaboratorios',
                'cie10Afiliado.cie10',
                'planCuidado',
                'informacionSalud',
                'PracticaCrianza',
                'ordenes.procedimientos' => function ($query) {
                    $query->whereIn('estado_id', [1, 4]);
                },
                'ordenes.articulos' => function ($query) {
                    $query->whereIn('estado_id', [1, 4]);
                },
                'especialidad',
                'rep',
                'insumos.codesumi',
                'patologias',
                'antecedentesOdontologicos',
                'examenFisicoOdontologicos',
                'examenTejidoOdontologicos',
                'odontograma',
                'paraclinicosOdontologicos',
                'planTramientoOdontologia',
                'adherenciaFarmaceutica',
                'cupGinecologicos',
                'cupMamografias',
                'antecedentesFarmacologicos',
                'antecedentesFamiliares',
                'antecedentesSexuales',
                'patologiaRespiratoria',
                'adjuntos',
                'rxFinal',
                'framingham',
                'odontogramaImagen',
                'cuestionarioVale',
                'TestRqc',
                'FiguraHumana',
                'testSrq',
                'estadoComportamiento',
                'transcripcion',
                'organosFonoarticulatorios',
                'respuestaSivigila',
                'resgistroSivigila',
                'estructuraDinamica',
                'minuta',
                'valoracionAntropometrica',
                'neuropsicologia'
            ])
            ->get();
    }

    /**
     * Crea una nueva consulta de telesalud
     * @param int $afiliado_id
     * @return Consulta
     */
    public function crearConsultaTelesalud($afiliado_id)
    {
        return $this->consultaModel->create([
            'finalidad' => 'Teleapoyo',
            'afiliado_id' => $afiliado_id,
            'medico_ordena_id' => auth()->user()->id,
            'tipo_consulta_id' => 84
        ]);
    }

    public function consultarCitas($data)
    {
        $urlProyecto = config('services.app_name.nombre_app');
        $esProyectoMedicinaIntegral = $urlProyecto === 'https://medicinaintegral.horus-health.com';
        $estado = [10, 13, 59, 67];
        if ($esProyectoMedicinaIntegral) {
            $estado = [10, 13, 59, 9, 7, 14];
        }
        return Consulta::with([
            'agenda.consultorio.rep',
            'agenda.medicos.operador',
            'cita.especialidad',
            'user.operador',
            'estado',
            'cobro',
            'consultaOrdenProcedimientos.ordenProcedimiento:id,cup_id,estado_id,cantidad_usada,cantidad_pendiente',
            'consultaOrdenProcedimientos.ordenProcedimiento.cup:id,codigo,nombre',
            'consultaOrdenProcedimientos.ordenProcedimiento.estado:id,nombre',
            'consultaOrdenProcedimientos.ordenProcedimiento.cobro',
            'afiliado.entidad:id,nombre'
        ])
            ->where('afiliado_id', $data['afiliado'])
            ->whereIn('estado_id', $estado)
            ->whereNull('firma_paciente')
            ->whereNull('finalidad')
            ->where('cita_no_programada', '!=', true)->get();
    }

    /**
     * Listar diagnosticos de una consulta
     * @param $consulta_id
     * @return Collection
     * @author Thomas
     */
    public function listarDiagnosticosConsulta($consulta_id): Collection
    {
        return $this->consultaModel->findOrFail($consulta_id)->cie10Afiliado()->get();
    }

    public function consultarCompleto($request, $historiaClinica = null)
    {
        $consultaId = $request->consulta;

        $consulta = $this->consultaModel
            ->with([
                'agenda',
                'agenda.consultorio.rep',
                'afiliado.tipoDocumento',
                'cita',
                'cita.categorias',
                'cita.categorias.campos',
                'historia',
                'historia.clinica',
                'medicoOrdena.operador',
                'HistoriaClinica.NotaAclaratoria',
                'antecedentePersonales',
                'antecedentesFarmacologicos.medicamento.codesumi',
                'antecedentesFamiliares',
                'antecedenteTransfucionales',
                'vacunacion',
                'antecedenteQuirurgicos',
                'antecedenteHospitalarios',
                'antecedentesSexuales',
                'antecedenteEcomapa',
                'antecedenteFamiliograma',
                'resultadoLaboratorios',
                'cie10Afiliado.cie10',
                'planCuidado',
                'informacionSalud',
                'PracticaCrianza',
                'ordenes.procedimientos' => function ($query) {
                    $query->whereIn('estado_id', [1, 4]);
                },
                'ordenes.articulos' => function ($query) {
                    $query->whereIn('estado_id', [1, 4]);
                },
                'especialidad',
                'rep',
                'insumos.codesumi',
                'patologias',
                'antecedentesOdontologicos',
                'examenFisicoOdontologicos',
                'examenTejidoOdontologicos',
                'odontograma',
                'paraclinicosOdontologicos',
                'planTramientoOdontologia',
                'adherenciaFarmaceutica',
                'cupGinecologicos',
                'cupMamografias',
                'antecedentesFarmacologicos',
                'antecedentesFamiliares',
                'antecedentesSexuales',
                'patologiaRespiratoria',
                'adjuntos',
                'rxFinal',
                'framingham',
                'odontogramaImagen',
                'cuestionarioVale',
                'TestRqc',
                'FiguraHumana',
                'testSrq',
                'estadoComportamiento',
                'transcripcion',
                'organosFonoarticulatorios',
                'respuestaSivigila',
                'resgistroSivigila',
                'estructuraDinamica',
                'minuta',
                'valoracionAntropometrica',
                'neuropsicologia'
            ])->where('id', $consultaId);

        if ($historiaClinica) {
            return $consulta->with(
                [
                    'sistemaRespiratorio',
                    'medicoOrdena.especialidades',
                    'HistoriaClinica.finalidadConsulta',
                    'HistoriaClinica.causaConsulta',
                    'resultadoLaboratorios.user.operador',
                    'odontogramaNuevo',
                    'remision',
                    'gestanteGinecologico',
                    'whooley',
                    'gad2'
                ]
            )->first();
        } else {
            return $consulta->get();
        }
    }

    public function actualizarEstadoGestion($id, $estado)
    {
        try {
            $consultaOrdenProcedimiento = ConsultaOrdenProcedimientos::where('consulta_id', $id)->first();
            $consulta = Consulta::find($id);
            if ($consultaOrdenProcedimiento) {
                $datos = [];
                $datosGestion = [];
                switch ($estado) {
                    case 8:
                        $datos = [
                            'observaciones' => $consulta->motivo_inadecuacion,
                            'estado_id_gestion_prestador' => 8
                        ];
                        $datosGestion = [
                            'observacion' => $consulta->motivo_inadecuacion,
                            'estado_gestion_id' => 8
                        ];
                        break;
                    case 51:
                        $datos = [
                            'fecha_ejecucion' => date('Y-m-d'),
                            'fecha_resultado' => date('Y-m-d'),
                            'observaciones' => 'Consecutivo historia Clinica (' . $consulta->id . ')',
                            'estado_id_gestion_prestador' => 51
                        ];
                        $datosGestion = [
                            'fecha_ejecucion' => date('Y-m-d'),
                            'fecha_asistencia' => date('Y-m-d'),
                            'observacion' => 'Consecutivo historia Clinica (' . $consulta->id . ')',
                            'estado_gestion_id' => 51
                        ];
                        break;
                    case 30:
                        $datos = [
                            'fecha_cancelacion' => date('Y-m-d'),
                            'estado_id_gestion_prestador' => 50
                        ];

                        $datosGestion = [
                            'funcionario_responsable',
                            'observacion' => $consulta->motivo_cancelacion,
                            'estado_gestion_id' => 50
                        ];
                        $operador = Operadore::where('user_id', $consulta->funcionario_cancela)->first();
                        if ($operador) {
                            $datosGestion['funcionario_responsable'] = $operador->nombre . ' ' . $operador->apellido;
                        }
                        break;
                }
                if ($consultaOrdenProcedimiento->orden_procedimiento_id) {
                    OrdenProcedimiento::where('id', $consultaOrdenProcedimiento->orden_procedimiento_id)->update($datos);
                    $datosGestion['orden_procedimiento_id'] = $consultaOrdenProcedimiento->orden_procedimiento_id;
                } else {
                    OrdenCodigoPropio::where('id', $consultaOrdenProcedimiento->orden_codigo_propio_id)->update($datos);
                    $datosGestion['orden_codigo_propio_id'] = $consultaOrdenProcedimiento->orden_codigo_propio_id;
                }
                GestionOrdenPrestador::create($datosGestion);
            }
        } catch (\Exception $exception) {
        }
    }

    public function obtenerConsultaTriage($consulta_id)
    {
        return $this->consultaModel::with('cita.especialidad', 'afiliado.tipoDocumento')->find($consulta_id);
    }


    public function recomendacionesCie10($request)
    {
        $consulta = $this->consultaModel->with(
            'afiliado',
            'medicoOrdena',
            'HistoriaClinica'
        )
            ->where('id', $request['consulta_id'])->first();

        $funcionario = $this->operador::where('user_id', Auth::id())->first();

        return (object) [
            'consulta' => $consulta,
            'funcionario' => $funcionario,
        ];
    }

    /**
     * Función que permite generar un PDF de acuerdo con la información recibida como datos y según el tipo de anexo seleccionado. (3 o 9)
     * @param mixed $data
     * @param int $tipoAnexo (3,9)
     */
    public function anexos($data, int $tipoAnexo, $otroServicio = false)
    {
        $ordenProcedimiento = null;
        $consulta = null;

        #segun el tipo de anexo realizo la consulta adecuada
        switch ($tipoAnexo) {
            case 3:
                if ($otroServicio) {
                    $ordenCodigoPropio = OrdenCodigoPropio::with([
                        'orden.consulta',
                        'orden.consulta.historiaClinica:id,destino_paciente,finalidad_id',
                        'orden.consulta.historiaClinica.finalidadConsulta:id,nombre',
                        'orden.consulta.historiaClinica.causaConsulta:id,codigo,nombre',
                        'orden.consulta.medicoOrdena:id,email',
                        'orden.consulta.medicoOrdena.operador',
                        'orden.consulta.medicoOrdena.especialidades:id,nombre',
                        'orden.consulta.afiliado:id,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,numero_documento,fecha_nacimiento,tipo_documento,telefono,direccion_residencia_cargue,correo1,celular1,celular2,nombre_responsable,entidad_id,mpio_residencia_id,dpto_residencia_id',
                        'orden.consulta.afiliado.municipio_residencia:id,nombre,codigo_dane',
                        'orden.consulta.afiliado.departamento_residencia:id,nombre,codigo_dane',
                        'orden.consulta.afiliado.clasificacion' => function ($query) {
                            $query->where('nombre', 'Maternas');
                        },
                        'codigoPropio.cup',

                    ])->where('id', $data['ordenamiento_id'])->first();
                    $consulta = $ordenCodigoPropio->orden->consulta;
                    break;
                }

                $ordenProcedimiento = OrdenProcedimiento::with([
                    'orden.consulta',
                    'orden.consulta.historiaClinica:id,destino_paciente,finalidad_id',
                    'orden.consulta.historiaClinica.finalidadConsulta:id,nombre',
                    'orden.consulta.historiaClinica.causaConsulta:id,codigo,nombre',
                    'orden.consulta.medicoOrdena:id,email',
                    'orden.consulta.medicoOrdena.operador',
                    'orden.consulta.medicoOrdena.especialidades:id,nombre',
                    'orden.consulta.afiliado:id,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,numero_documento,fecha_nacimiento,tipo_documento,telefono,direccion_residencia_cargue,correo1,celular1,celular2,nombre_responsable,entidad_id,mpio_residencia_id,dpto_residencia_id',
                    'orden.consulta.afiliado.municipio_residencia:id,nombre,codigo_dane',
                    'orden.consulta.afiliado.departamento_residencia:id,nombre,codigo_dane',
                    'orden.consulta.afiliado.clasificacion' => function ($query) {
                        $query->where('nombre', 'Maternas');
                    },

                ])->where('id', $data['ordenamiento_id'])->first();
                $consulta = $ordenProcedimiento->orden->consulta;
                break;

            case 4:
                $ordenArticulo = OrdenArticulo::with([
                    'orden.consulta',
                    'orden.consulta.historiaClinica:id,destino_paciente,finalidad_id',
                    'orden.consulta.historiaClinica.finalidadConsulta:id,nombre',
                    'orden.consulta.historiaClinica.causaConsulta:id,codigo,nombre',
                    'orden.consulta.medicoOrdena:id,email',
                    'orden.consulta.medicoOrdena.operador',
                    'orden.consulta.medicoOrdena.especialidades:id,nombre',
                    'orden.consulta.afiliado:id,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,numero_documento,fecha_nacimiento,tipo_documento,telefono,direccion_residencia_cargue,correo1,celular1,celular2,nombre_responsable,entidad_id,mpio_residencia_id,dpto_residencia_id',
                    'orden.consulta.afiliado.municipio_residencia:id,nombre,codigo_dane',
                    'orden.consulta.afiliado.departamento_residencia:id,nombre,codigo_dane',
                    'orden.consulta.afiliado.clasificacion' => function ($query) {
                        $query->where('nombre', 'Maternas');
                    },
                ])->where('id', $data['ordenamiento_id'])->first();
                $consulta = $ordenArticulo->orden->consulta;

                break;

            case 9:
                $consulta = $this->consultaModel->with([
                    'afiliado:id,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,numero_documento,fecha_nacimiento,tipo_documento,telefono,direccion_residencia_cargue,correo1,celular1,celular2,nombre_responsable,entidad_id,mpio_residencia_id,dpto_residencia_id',
                    'afiliado.municipio_residencia:id,nombre,codigo_dane',
                    'afiliado.departamento_residencia:id,nombre,codigo_dane',
                    'afiliado.clasificacion' => function ($query) {
                        $query->where('nombre', 'Maternas');
                    },
                    'historiaClinica:id,destino_paciente,finalidad_id,especialidad',
                    'historiaClinica.causaConsulta:id,codigo,nombre',
                    'historiaClinica.finalidadConsulta:id,nombre',
                    'medicoOrdena:id,email',
                    'medicoOrdena.operador',
                    'medicoOrdena.especialidades:id,nombre'
                ])->where('id', $data['consulta_id'])->first();
                break;
        }

        #obtengo el afiliado
        $afiliado = $consulta->afiliado;

        #obtengo la historia clinica con la causa de consulta
        $historiaClinica = $consulta->HistoriaClinica ?? null;

        #obtengo el cie10 con diagnostico principal
        $cie10DiagnosticoPpal = Cie10Afiliado::with('cie10')->where('consulta_id', $consulta->id)->where('esprimario', true)->first();
        $cie10 = $cie10DiagnosticoPpal->cie10 ?? null;


        #obtengo el diagnostico relacionado
        $cie10DiagnosticoRelacionado = Cie10Afiliado::with(['cie10'])->where('consulta_id', $consulta->id)
            ->where('esprimario', false)
            ->get();
        $cie10DiagnosticoRelacionado ?? null;

        #obtengo los 3 primeros cie10 relacionados si los hay.
        $cie10Relacionado = $cie10DiagnosticoRelacionado->take(3)->pluck('cie10')->unique();


        switch ($tipoAnexo) {
            case 3:
                if ($otroServicio) {
                    $orden = $ordenCodigoPropio;
                } else {
                    $orden = $ordenProcedimiento;
                }
                break;
            case 4:
                $orden = $ordenArticulo;
                break;
            case 9:
                $orden = null;
                break;
        }

        return (object) [
            'cie10' => $cie10,
            'afiliado' => $afiliado,
            'historiaClinica' => $historiaClinica,
            'ordenProcedimiento' => $orden,
            'consulta' => $consulta,
            'cie10Relacionado' => $cie10Relacionado,
        ];
    }

    public function evolucionCertificado($request)
    {
        $consulta = $this->consultaModel->with(
            'admision',
            'afiliado',
            'afiliado.tipoDocumento',
            'afiliado.entidad',
            'afiliado.municipio_afiliacion',
            'afiliado.tipo_afiliado',
        )->where('id', $request['consulta'])->first();

        $evolucion = $this->evolucion->where('consulta_id', $consulta->id)->with(['createBy.operador', 'createBy.especialidades'])->orderBy('id', 'ASC')->get();

        return (object) [
            'consulta' => $consulta,
            'evolucion' => $evolucion,
        ];
    }

    public function certificadoMedimas($request)
    {
        $consulta = $this->consultaModel->with(
            'afiliado',
            'afiliado.tipoDocumento',
            'afiliado.entidad',
            'admision'
        )->where('id', $request['consulta'])->first();

        return $consulta;
    }

    public function anexo2($request)
    {
        $consulta = $this->consultaModel->with(
            'HistoriaClinica',
            'afiliado',
            'afiliado.municipio_atencion',
            'afiliado.departamento_atencion'
        )
            ->where('id', $request['consulta'])->first();

        return $consulta;
    }

    public function consentimientoTelemedicina($request)
    {
        $consulta = $this->consultaModel->select([
            'firma_consentimiento',
            'id',
            'afiliado_id',
            'firma_consentimiento_time',
            'medico_ordena_id'
        ])->with([
                    'afiliado:id,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,numero_documento,edad_cumplida,numero_documento,entidad_id',
                    'medicoOrdena.operador',
                    'afiliado.entidad'
                ])
            ->where('consultas.id', $request->consulta_id)
            ->where('especialidad_id', '<>', 14)
            ->first();

        return $consulta;
    }

    public function consentimientoAnestesia($id)
    {
        $consulta = $this->consultaModel->select([
            'firma_consentimiento',
            'id',
            'afiliado_id',
            'firma_consentimiento_time',
            'medico_ordena_id',
            'aceptacion_consentimiento',
            'declaracion_a',
            'declaracion_b',
            'declaracion_c',
            'firma_acompanante',
            'nombre_representante',
            'numero_documento_representante'
        ])->with([
                    'afiliado:id,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,numero_documento,edad_cumplida,numero_documento,entidad_id',
                    'medicoOrdena.operador',
                    'afiliado.entidad'
                ])
            ->where('consultas.id', $id)
            ->where('especialidad_id', 14)
            ->first();

        return $consulta;
    }

    public function recomendacionesCups($request)
    {
        $consulta = $this->consultaModel->with(
            'afiliado',
            'medicoOrdena',
            'HistoriaClinica',
        )
            ->where('id', $request['consulta_id'])->first();

        $recomendacion = $this->recomendaciones->where('cup_id', $request['cup_id'])->where('estado_id', 1)->get();


        return (object) [
            'consulta' => $consulta,
            'recomendacion' => $recomendacion,
        ];
    }

    public function recomendacionesConsultas($id)
    {
        $consulta = $this->consultaModel->with([
            'afiliado',
            'recomendacionConsulta',
            'ordenes',
            'afiliado.tipoDocumento',
            'afiliado.ips',
            'afiliado.departamento_atencion',
            'afiliado.municipio_atencion'

        ])->where('id', $id)->first();

        return $consulta;
    }

    /**
     * Verificar si el medico atiende la consulta, sino lo actualiza
     * @param int $consultaId
     * @return void
     * @author Thomas
     */
    public function verificarMedicoAtiende(int $consultaId)
    {
        $consulta = $this->consultaModel->findOrFail($consultaId);

        if ($consulta->medico_ordena_id != Auth::id()) {
            $consulta->update([
                'medico_ordena_id' => Auth::id()
            ]);
        }
    }

    /**
     * Obtiene una consulta por su ID incluyendo el afiliado relacionado.
     * Verifica que la consulta exista y que tenga un afiliado asociado.
     * Lanza una excepción si la consulta no existe o no tiene afiliado.
     *
     * @param int $idConsulta ID de la consulta a obtener.
     * @return  La instancia de la consulta con su afiliado cargado.
     * @throws \Exception Si la consulta no existe o no tiene un afiliado.
     * @author Kobatime
     */

    public function obtenerConsulta(int $idConsulta)
    {

        $consulta = Consulta::with('afiliado')
            ->select('id', 'afiliado_id')
            ->find($idConsulta);

        return $consulta;
    }

    public function ConsultasPorEspecialidad($request)
    {
        $afiliado_id = $request['afiliado'];
        $tipos = [44, 43, 19, 46];

        $consultas = Consulta::with([
            'especialidad:id,nombre',
            'medicoOrdena.operador:user_id,nombre,apellido'
        ])
            ->select('consultas.*')
            ->join('citas', 'consultas.cita_id', '=', 'citas.id')
            ->join('especialidades', 'citas.especialidade_id', '=', 'especialidades.id')
            ->where('consultas.afiliado_id', $afiliado_id)
            ->whereIn('especialidades.id', $tipos)
            ->orderBy('consultas.fecha_hora_inicio', 'desc')
            ->get()
            ->groupBy('especialidad_id')
            ->map(function ($grupo) {
                return $grupo->first();
            });

        $resultado = collect($tipos)->map(function ($tipo) use ($consultas) {
            if (isset($consultas[$tipo])) {
                $c = $consultas[$tipo];

                $estado = match ($c->estado_id) {
                    13 => 'Programada',
                    9  => 'Atendido',
                    7 => 'Pendiente',
                    default => 'Por gestionar'
                };

                $nombreMedico = $c->medicoOrdena && $c->medicoOrdena->operador
                    ? trim($c->medicoOrdena->operador->nombre . ' ' . $c->medicoOrdena->operador->apellido)
                    : 'Sin nombre';

                return [
                    'especialidad_id' => $tipo,
                    'nombre_tipo' => $c->especialidad->nombre,
                    'fecha' => $c->fecha_hora_inicio,
                    'estado' => $estado,
                    'medico' => $nombreMedico
                ];
            } else {
                return [
                    'especialidad_id' => $tipo,
                    'nombre_tipo' => Especialidade::find($tipo)->nombre,
                    'fecha' => null,
                    'estado' => '',
                    'medico' => ''
                ];
            }
        });

        return $resultado->values();
    }
}
