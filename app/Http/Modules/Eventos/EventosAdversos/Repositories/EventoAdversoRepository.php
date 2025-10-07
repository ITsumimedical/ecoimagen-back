<?php

namespace App\Http\Modules\Eventos\EventosAdversos\Repositories;

use App\Formats\AnalisisCasos;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Eventos\AccionesMejora\Models\AccionesMejoraEvento;
use App\Http\Modules\Eventos\Analisis\Models\AnalisisEvento;
use App\Http\Modules\Eventos\GestionEventos\Models\GestionEvento;
use App\Http\Modules\Eventos\EventosAdversos\Models\EventoAdverso;
use Illuminate\Support\Collection;

class EventoAdversoRepository extends RepositoryBase
{

    protected AnalisisEvento $analisisEvento;
    protected AccionesMejoraEvento $accionesMejoraEvento;

    public function __construct(
        EventoAdverso $eventoAdverso,
        AnalisisEvento $analisisEvento,
        AccionesMejoraEvento $accionesMejoraEvento
    ) {
        $this->model = $eventoAdverso;
        $this->analisisEvento = $analisisEvento;
        $this->accionesMejoraEvento = $accionesMejoraEvento;
    }

    public function listarEventosAfiliado($data, $id)
    {
        /** Definimos el orden*/
        $orden = isset($data->orden) ? $data->orden : 'desc';
        if ($data->page) {
            $filas = $data->filas ? $data->filas : 10;
            return $this->model
                ->with('suceso', 'clasificacionArea')
                ->orderBy('created_at', $orden)
                ->paginate($filas)
                ->where('afiliado_id', $id);
        } else {
            return $this->model
                ->with('suceso', 'clasificacionArea')
                ->orderBy('created_at', $orden)
                ->where('afiliado_id', $id)
                ->get();
        }
    }

    public function reporte($data)
    {
        $appointments = DB::select("SELECT * FROM fn_reporte_eventos_adversos(?,?)", [
            $data['f_init'],
            $data['f_fin'],
        ]);

        return (new FastExcel($appointments))->download('EventosAdversos.xls');
    }

    public function listarEventos($filters)
    {
        $usuario_logueado = Auth::id();

        $query = EventoAdverso::select(
            'analisis_eventos.elemento_funcion',
            'analisis_eventos.modo_fallo',
            'analisis_eventos.efecto',
            'analisis_eventos.npr',
            'analisis_eventos.acciones_propuestas',
            'analisis_eventos.causas_esavi',
            'analisis_eventos.asociacion_esavi',
            'analisis_eventos.ventana_mayoriesgo',
            'analisis_eventos.evidencia_asociacioncausal',
            'analisis_eventos.factores_esavi',
            'analisis_eventos.evaluacion_causalidad',
            'analisis_eventos.clasificacion_invima',
            'analisis_eventos.seriedad',
            'analisis_eventos.fecha_muerte',
            'analisis_eventos.farmaco_cinetica',
            'analisis_eventos.condiciones_farmacocinetica',
            'analisis_eventos.prescribio_manerainadecuada',
            'analisis_eventos.medicamento_manerainadecuada',
            'analisis_eventos.medicamento_entrenamiento',
            'analisis_eventos.potenciales_interacciones',
            'analisis_eventos.notificacion_refieremedicamento',
            'analisis_eventos.problema_biofarmaceutico',
            'analisis_eventos.deficiencias_sistemas',
            'analisis_eventos.factores_asociados',
            'evento_adversos.id',
            'evento_adversos.descripcion_hechos',
            'evento_adversos.accion_tomada',
            'analisis_eventos.metodologia_analisis_farmaco',
            'sedeOcurrencia.nombre as sede_ocurrencia',
            'evento_adversos.sede_ocurrencia_id',
            'evento_adversos.clasificacion_area_id',
            'sedeReportante.nombre as sede_reportante',
            'evento_adversos.fecha_ocurrencia',
            DB::raw("TO_CHAR(evento_adversos.created_at, 'YYYY-MM-DD') as fecha_creacion"),
            'sucesos.nombre as nombre_suceso',
            'evento_adversos.estado_id',
            'evento_adversos.suceso_id',
            'clasificacion_areas.nombre as nombre_clasificacion',
            'tipo_eventos.nombre as nombre_tipo_evento',
            'evento_adversos.created_at',
            'evento_adversos.sede_reportante_id',
            'evento_adversos.servicio_ocurrencia',
            'evento_adversos.afiliado_id',
            'evento_adversos.clasif_tecnovigilancia',
            'evento_adversos.priorizacion',
            'evento_adversos.voluntariedad',
            'evento_adversos.motivo_anulacion_id',
            'motivo_anulacion_eventos.nombre as motivo_anulacion',
            'evento_adversos.clasificacion_anulacion',
            'evento_adversos.otros_motivo_anulacion',
            'evento_adversos.identificacion_riesgo',
            'afiliados.numero_documento as numero_documento_afiliado',
            'evento_adversos.dispositivo_id',
            'codesumis.nombre as dispositivo',
            'evento_adversos.referencia_dispositivo',
            'evento_adversos.marca_dispositivo',
            'evento_adversos.lote_dispositivo',
            'evento_adversos.invima_dispositivo',
            'evento_adversos.invima_equipo_biomedico',
            'evento_adversos.nombre_equipo_biomedico',
            'evento_adversos.marca_equipo_biomedico',
            'evento_adversos.modelo_equipo_biomedico',
            'evento_adversos.serie_equipo_biomedico',
            'evento_adversos.fabricante_dispositivo',
            'evento_adversos.fabricante_biomedico',
            'evento_adversos.relacion',
            'afiliados.sexo',
            'afiliados.edad_cumplida',
            'entidades.nombre as entidad_afiliado',
            'analisis_eventos.fecha_analisis',
            'analisis_eventos.cronologia_suceso',
            'analisis_eventos.clasificacion_analisis',
            'analisis_eventos.metodologia_analisis',
            'analisis_eventos.que_fallo',
            'analisis_eventos.como_fallo',
            'analisis_eventos.que_causo',
            'analisis_eventos.plan_accion',
            'analisis_eventos.accion_resarcimiento',
            'analisis_eventos.descripcion_consecuencias',
            'analisis_eventos.desenlace_evento',
            'analisis_eventos.severidad_evento',
            'analisis_eventos.id as analisis_evento_id',
            'operadores.cargo_id',
            'cargos.nombre as cargo_nombre',
            DB::raw("CONCAT(operadores.nombre, ' ', operadores.apellido) as usuario_registra"),
            'reps.nombre as nombre_ips',
            'evento_adversos.tipo_evento_id',
        )
            ->join('reps as sedeOcurrencia', 'sedeOcurrencia.id', 'evento_adversos.sede_ocurrencia_id')
            ->join('reps as sedeReportante', 'sedeReportante.id', 'evento_adversos.sede_reportante_id')
            ->join('sucesos', 'sucesos.id', 'evento_adversos.suceso_id')
            ->leftJoin('users as usuarioRegistra', 'usuarioRegistra.id', 'evento_adversos.user_id')
            ->leftJoin('operadores', 'usuarioRegistra.id', 'operadores.user_id')
            ->leftJoin('cargos', 'operadores.cargo_id', 'cargos.id')
            ->leftJoin('clasificacion_areas', 'clasificacion_areas.id', 'evento_adversos.clasificacion_area_id')
            ->leftJoin('tipo_eventos', 'tipo_eventos.id', 'evento_adversos.tipo_evento_id')
            ->leftJoin('empleados as profesionalTratante', 'profesionalTratante.id', 'evento_adversos.profesional_id')
            ->leftJoin('analisis_eventos', 'evento_adversos.id', 'analisis_eventos.evento_adverso_id')
            ->leftJoin('motivo_anulacion_eventos', 'motivo_anulacion_eventos.id', 'evento_adversos.motivo_anulacion_id')
            ->leftJoin('afiliados', DB::raw('CAST(evento_adversos.afiliado_id AS bigint)'), 'afiliados.id')
            ->leftJoin('entidades', 'afiliados.entidad_id', 'entidades.id')
            ->leftJoin('reps', 'afiliados.ips_id', 'reps.id')
            ->leftJoin('codesumis', 'evento_adversos.dispositivo_id', 'codesumis.id')
            ->orderBy('analisis_eventos.id', 'desc')
            ->whereExists(function ($query) use ($usuario_logueado) {
                $query->select(DB::raw(1))
                    ->from('evento_asignados')
                    ->whereRaw('evento_asignados.evento_adverso_id = evento_adversos.id')
                    ->where('evento_asignados.user_id', $usuario_logueado);
            })
            ->with('adjuntos')
            ->distinct()
            ->selectRaw("CONCAT(afiliados.primer_nombre, ' ', afiliados.primer_apellido, ' ', afiliados.segundo_nombre, ' ', afiliados.segundo_apellido) as nombre_afiliado");

        $query->when(!empty($filters['cedula']), function ($q) use ($filters) {
            $q->where("afiliados.numero_documento", $filters['cedula']);
        });

        if (!empty($filters['estados'])) {
            $query->whereIn('evento_adversos.estado_id', $filters['estados']);
        }

        if (!empty($filters['fecha_desde'])) {
            $query->whereDate('evento_adversos.created_at', '>=', $filters['fecha_desde']);
        }

        if (!empty($filters['fecha_hasta'])) {
            $query->whereDate('evento_adversos.created_at', '<=', $filters['fecha_hasta']);
        }

        $query->when(!empty($filters['id']), function ($q) use ($filters) {
            $q->where('evento_adversos.id', $filters['id']);
        });

        $query->when(!empty($filters['nombre']), function ($q) use ($filters) {
            $nombre = strtolower($filters['nombre']);
            $q->where(function ($subQuery) use ($nombre) {
                $columns = ['primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido'];
                foreach ($columns as $column) {
                    $subQuery->orWhere("afiliados.$column", 'ILIKE', "%{$nombre}%");
                }
            });
        });


        $query->when(!empty($filters['sede_ocurrencia']), function ($q) use ($filters) {
            $q->whereHas('sedeOcurrencia', function ($subQuery) use ($filters) {
                $subQuery->where('nombre', 'ILIKE', "%{$filters['sede_ocurrencia']}%");
            });
        });



        $query->when(!empty($filters['suceso']), function ($q) use ($filters) {
            $q->whereHas('suceso', function ($subQuery) use ($filters) {
                $subQuery->where('nombre', 'ILIKE', "%{$filters['suceso']}%");
            });
        });

        $eventos = $query->paginate($filters['cantidad']);

        return $eventos;
    }


    public function listarEventosPorId($id)
    {
        return $this->model::where('id', $id)
            ->with([
                'sedeReporta:id,nombre',
                'sedeOcurrencia:id,nombre',
                'afiliado:id,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,numero_documento,sexo,edad_cumplida,entidad_id,ips_id',
                'afiliado.entidad:id,nombre',
                'afiliado.ips:id,nombre',
                'userRegistra:id',
                'userRegistra.operador:user_id,nombre,apellido,cargo_id',
                'userRegistra.operador.cargo:id,nombre',
                'dipositivo:id,nombre',
                'analisisEvento.accionInsegura:analisis_evento_id',
                'tipoEvento:id,nombre',
                'adjuntos'
            ])->first();
    }

    public function formatoAnalisisCasos($request)
    {
        $eventosAdverso = $this->model::select(
            'evento_adversos.id',
            'evento_adversos.fecha_ocurrencia',
            'evento_adversos.sede_ocurrencia_id',
            'evento_adversos.servicio_ocurrencia',
            'evento_adversos.created_at',
            'evento_adversos.descripcion_hechos',
            'evento_adversos.referencia_dispositivo',
            'evento_adversos.marca_dispositivo',
            'evento_adversos.lote_dispositivo',
            'evento_adversos.invima_dispositivo',
            'evento_adversos.fabricante_dispositivo',
            'evento_adversos.dispositivo_id',
            'codesumis.nombre as dispositivo',
            'evento_adversos.nombre_equipo_biomedico',
            'evento_adversos.marca_equipo_biomedico',
            'evento_adversos.modelo_equipo_biomedico',
            'evento_adversos.serie_equipo_biomedico',
            'evento_adversos.fabricante_biomedico',
            'evento_adversos.invima_equipo_biomedico',
            'evento_adversos.relacion',
            'evento_adversos.suceso_id',
            'sucesos.nombre as suceso_nombre',
            'evento_adversos.accion_tomada',
            'afiliados.numero_documento',
            'afiliados.edad_cumplida',
            'reps.nombre as sedeOcurrencia',
            'analisis_eventos.fecha_analisis',
            'analisis_eventos.cronologia_suceso',
            'analisis_eventos.metodologia_analisis',
            'analisis_eventos.que_fallo',
            'analisis_eventos.como_fallo',
            'analisis_eventos.que_causo',
            'analisis_eventos.plan_accion',
            'analisis_eventos.descripcion_consecuencias',
            'analisis_eventos.clasificacion_analisis',
            'analisis_eventos.clasif_tecnovigilancia',
            'analisis_eventos.accion_resarcimiento',
            'analisis_eventos.id as analisis_id',
            'clasificacion_areas.nombre as clasificacion_area_nombre',
            'tipo_eventos.nombre as tipo_evento_nombre'
        )
            ->selectRaw("CONCAT(afiliados.primer_nombre, ' ', afiliados.primer_apellido, ' ', afiliados.segundo_apellido) as nombre_afiliado")
            ->leftJoin('afiliados', DB::raw('CAST(evento_adversos.afiliado_id AS bigint)'), 'afiliados.id')
            ->leftJoin('analisis_eventos', 'evento_adversos.id', 'analisis_eventos.evento_adverso_id')
            ->leftJoin('codesumis', 'evento_adversos.dispositivo_id', 'codesumis.id')
            ->join('reps', 'reps.id', 'evento_adversos.sede_ocurrencia_id')
            ->leftJoin('sucesos', 'sucesos.id', 'evento_adversos.suceso_id')
            ->leftJoin('clasificacion_areas', 'clasificacion_areas.id', 'evento_adversos.clasificacion_area_id')
            ->leftJoin('tipo_eventos', 'tipo_eventos.id', 'evento_adversos.tipo_evento_id')
            ->where('evento_adversos.id', $request['id'])
            ->first();

        $acciones_seguras = $this->analisisEvento->select('a.*')
            ->leftjoin('acciones_inseguras as a', 'a.analisis_evento_id', 'analisis_eventos.id')
            ->where('a.analisis_evento_id', $eventosAdverso->analisis_id)
            ->whereNull('deleted_at')->get();


        $analisisEvento = $this->analisisEvento::find($eventosAdverso->analisis_id);
        $accionesMejorasEventos = $this->accionesMejoraEvento::where('analisis_evento_id', $eventosAdverso->analisis_id)->get();


        return (object)[
            'eventosAdvero' => $eventosAdverso,
            'accionesSeguras' => $acciones_seguras,
            'analisisEvento' => $analisisEvento,
            'accionesMejorasEventos' => $accionesMejorasEventos,
        ];
    }

    /**
     * Lista los seguimientos IAAS (Infecciones asociadas al cuidado de la salud)
     * por mes y año seleccionados.
     *
     * @param array{mes:int, anio:int} $data
     * @return Collection
     */
    public function listarSeguimientoIAAS(array $data): Collection
    {
        $mes  = (int) $data['mes'];
        $anio = (int) $data['anio'];

        $query = "
        (select 
            afiliados.id as afiliado_id,
            concat_ws(' ', afiliados.primer_nombre, afiliados.segundo_nombre, afiliados.primer_apellido, afiliados.segundo_apellido) as afiliado_nombre,
            afiliados.numero_documento as afiliado_documento,
            afiliados.celular1, afiliados.celular2, afiliados.telefono,
            afiliados.correo1, afiliados.correo2,
            afiliados.direccion_residencia_cargue as direccion,
            parsed_fecha_consulta as fecha_atencion,
            acs.consulta as codigo_cups,
            cups.nombre as nombre_cups,
            acs.diagnostico_principal as codigo_diagnostico,
            cie10s.descripcion as nombre_diagnostico,
            'ACS' as origen
        from acs
        inner join afiliados on afiliados.numero_documento = acs.numero_documento
        left join cups on cups.codigo = acs.consulta
        left join cie10s on cie10s.codigo_cie10 = acs.diagnostico_principal
        cross join lateral (
            select 
                CASE 
                    WHEN acs.fecha_consulta ~ '^[0-9]{2}/[0-9]{2}/[0-9]{4}' 
                        THEN to_date(acs.fecha_consulta, 'DD/MM/YYYY')
                    ELSE acs.fecha_consulta::timestamp
                END as parsed_fecha_consulta
        ) as fecha_parseada
        where EXTRACT(MONTH FROM parsed_fecha_consulta) = :mes
          and EXTRACT(YEAR FROM parsed_fecha_consulta) = :anio
        )

        union all

        (select 
            afiliados.id as afiliado_id,
            concat_ws(' ', afiliados.primer_nombre, afiliados.segundo_nombre, afiliados.primer_apellido, afiliados.segundo_apellido) as afiliado_nombre,
            afiliados.numero_documento as afiliado_documento,
            afiliados.celular1, afiliados.celular2, afiliados.telefono,
            afiliados.correo1, afiliados.correo2,
            afiliados.direccion_residencia_cargue as direccion,
            parsed_fecha_procedimiento as fecha_atencion,
            aps.procedimiento as codigo_cups,
            cups.nombre as nombre_cups,
            aps.diagnostico_relacionado as codigo_diagnostico,
            cie10s.descripcion as nombre_diagnostico,
            'APS' as origen
        from aps
        inner join afiliados on afiliados.numero_documento = aps.numero_documento
        left join cups on cups.codigo = aps.procedimiento
        left join cie10s on cie10s.codigo_cie10 = aps.diagnostico_relacionado
        cross join lateral (
            select 
                CASE 
                    WHEN aps.fecha_procedimiento ~ '^[0-9]{2}/[0-9]{2}/[0-9]{4}' 
                        THEN to_date(aps.fecha_procedimiento, 'DD/MM/YYYY')
                    ELSE aps.fecha_procedimiento::timestamp
                END as parsed_fecha_procedimiento
        ) as fecha_parseada
        where EXTRACT(MONTH FROM parsed_fecha_procedimiento) = :mes
          and EXTRACT(YEAR FROM parsed_fecha_procedimiento) = :anio
        )
    ";

        return collect(DB::select($query, ['mes' => $mes, 'anio' => $anio]));
    }
}
