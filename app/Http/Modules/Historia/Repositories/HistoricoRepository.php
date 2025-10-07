<?php

namespace App\Http\Modules\Historia\Repositories;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Historia\Models\Historia;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Historia\Models\HistoriaClinica;
use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Modules\Historia\AntecedentesFarmacologicos\Models\AntecedentesFarmacologico;
use App\Http\Modules\Historia\AntecedentesGinecologicos\CupGinecologico;
use App\Http\Modules\Historia\AntecedentesGinecologicos\CupMamografia;

class HistoricoRepository extends RepositoryBase
{

    public function __construct(protected Historia $historiaModel)
    {
    }

    public function listarAntecedentes()
    {
        return $this->historiaModel::all(['tipo_transfusion', 'fecha_transfusion', 'causa', 'created_at']);
    }

    public function historicoOcupacional($cedula)
    {
        return Consulta::with(["agenda", "afiliado", "agenda.cita"])->whereHas('afiliado', function ($q) use ($cedula) {
            $q->where('numero_documento', $cedula);
        })->whereIn('tipo_consulta_id', [13, 14, 15, 16])->where('estado_id', 13)
            ->get();
    }

    public function examenFisico($data)
    {
        return HistoriaClinica::select(
            'peso',
            'talla',
            'imc',
            'isc',
            'clasificacion',
            'perimetro_abdominal',
            'perimetro_cefalico',
            'peso_talla',
            'clasificacion_peso_talla',
            'talla_edad',
            'clasificacion_talla_edad',
            'cefalico_edad',
            'clasificacion_cefalico_edad',
            'imc_edad',
            'clasificacion_imc_edad',
            'peso_edad',
            'clasificacion_peso_edad',
            'circunferencia_brazo',
            'circunferencia_pantorrilla',
            'ganancia_esperada',
            'created_at'
        )->whereHas('consulta.afiliado', function ($q) use ($data) {
            $q->where('afiliados.id', $data->afiliado);
        })
            ->whereNotNull('peso')
            ->whereNotNull('talla')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function contadores($data)
    {
        $contadorAntecedentesFarmacologicos = AntecedentesFarmacologico::select('id')
            ->whereHas('consulta.afiliado', function ($q) use ($data) {
                $q->where('afiliados.id', $data['afiliado']);
            })
            ->count();


        $contadorServicios = OrdenProcedimiento::select('id')
            ->whereHas('orden.consulta.afiliado', function ($q) use ($data) {
                $q->where('afiliados.id', $data['afiliado']);
            })
            ->whereHas('orden', function ($q) {
                $q->where('ordenes.tipo_orden_id', 2);
            })
            ->count(); // Contamos los registros

        $contadorMedicamentos = OrdenArticulo::select('id') // Seleccionamos solo el ID de OrdenArticulo
            ->whereHas('orden.consulta.afiliado', function ($q) use ($data) {
                $q->where('afiliados.id', $data['afiliado']);
            })
            ->whereHas('orden', function ($q) {
                $q->where('ordenes.tipo_orden_id', 1);
            })
            ->count(); // Contamos los registros

        $contadorConsultas = Consulta::select('id') // Seleccionamos solo el ID de Consulta
            ->where('afiliado_id', $data['afiliado'])
            ->whereNotIn('tipo_consulta_id', [1, 13, 14, 15, 16, 84, 87])
            ->count(); // Contamos los registros


        return (object) [
            'contadorAntecedentesFarmacologicos' => $contadorAntecedentesFarmacologicos,
            'contadorServicios' => $contadorServicios,
            'contadorMedicamentos' => $contadorMedicamentos,
            'contadorConsultas' => $contadorConsultas,
        ];
    }

    public function obtenerDatosBarthel($afiliadoId)
    {
        return HistoriaClinica::select(
            'barthel_comer',
            'barthel_lavarse',
            'barthel_vestirse',
            'barthel_arreglarse',
            'barthel_deposiciones',
            'barthel_miccion',
            'barthel_retrete',
            'barthel_trasladarse',
            'barthel_deambular',
            'barthel_escalones',
        )
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId)
                    ->whereHas('cita', function ($subQuery) {
                        $subQuery->where('tipo_historia_id', 10);
                    });
            })
            ->latest()
            ->first();
    }


    public function obtenerDatosKarnosfki($afiliadoId)
    {
        $datos = HistoriaClinica::select(
            'valor_scala_karnofski'
        )
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->whereNotNull('valor_scala_karnofski')
            ->orderBy('id', 'desc')
            ->first();

        return $datos;
    }


    public function obtenerDatosEcog($afiliadoId)
    {
        $datosEcog = HistoriaClinica::select(
            'valor_scala_ecog'
        )
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->whereNotNull('valor_scala_ecog')
            ->latest()
            ->first();

        return $datosEcog;
    }


    public function edmontonEsas($afiliadoId)
    {
        $datos = HistoriaClinica::select(
            'sin_dolor',
            'sin_cansancio',
            'sin_nauseas',
            'sin_tristeza',
            'sin_ansiedad',
            'sin_somnolencia',
            'sin_disnea',
            'buen_apetito',
            'maximo_bienestar',
            'sin_dificulta_para_dormir'
        )
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId)
                    ->whereHas('cita', function ($subQuery) {
                        $subQuery->where('tipo_historia_id', 3);
                    });
            })
            ->latest()
            ->first();
        return $datos;
    }

    public function estiloVida($afiliadoId)
    {
        $campos = [
            'frecuencia_dieta_saludable',
            'dieta_saludable',
            'dieta_balanceada',
            'cuantas_comidas',
            'leche',
            'alimento',
            'introduccion_alimentos',
            'sueno_reparador',
            'tipo_sueno',
            'duracion_sueno',
            'alto_nivel_estres',
            'actividad_fisica',
            'duracion_actividad_fisica',
            'frecuencia_actividad_fisica',
            'exposicion',
            'juego',
            'bano',
            'bucal',
            'posiciones',
            'esfinter',
            'esfinter_rectal',
            'caracteristicas_orina',
            'expuesto_humo',
            'anios_expuesto',
            'expuesto_psicoactivos',
            'anios_expuesto_sustancias',
            'fuma_cantidad',
            'fumamos',
            'tabaquico',
            'riesgo_epoc',
            'consumo_psicoactivo',
            'psicoactivo_cantidad',
            'cantidad_licor',
            'licor_frecuencia',
            'estilo_vida_observaciones'
        ];

        $estiloVida = HistoriaClinica::select($campos)
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->where(function ($query) use ($campos) {
                foreach ($campos as $campo) {
                    $query->orWhereNotNull($campo);
                }
            })
            ->latest('id')
            ->first();

        return $estiloVida;
    }


    public function obtenerDatosGinecobstetricos($afiliadoId)
    {
        $campos = [
            'antecedentes_obtetricos',
            'fecha_inicio_menopausia',
            'menopausia_presente',
            'presente_menarquia',
            'edad',
            'clasificacion_ciclos',
            'frecuencia_ciclos',
            'duracion_ciclos',
            'fecha_ultima_menstruacion',
            'presente_transmisionsexual',
            'descripcion_transmision_sexual',
            'edad_primera',
            'presente_metodo_anticonceptivo',
            'descripcion_metodo_anticonceptivo',
            'tipo_metodo_anticonceptivo',
            'tratamiento_metodo_anticonceptivo',
            'fecha_metodo_anticonceptivo',
            'presente_tratamiento_infertilidad',
            'tratamiento_tratamiento_infertilidad',
            'fecha_tratamiento_infertilidad',
            'presente_auto_examen_senos',
            'frecuencia_auto_examen_senos',
            'fecha_citologia',
            'resultado_citologia',
            'fecha_mamografia',
            'resultado_mamografia',
            'presente_procedimiento_cuello_uterino',
            'tratamiento_procedimiento_cuello_uterino',
            'fecha_procedimiento_cuello_uterino',
            'tratamiento_otro_tipo_tratamiento',
            'fecha_ultimo_parto',
            'planea_embarazo',
            'gesta',
            'parto',
            'aborto',
            'vivos',
            'cesarea',
            'mortinato',
            'ectopicos',
            'molas',
            'gemelos',
            'fecha_ultima_menstruacion_gestante',
            'gestacional_fum',
            'fecha_probable',
            'embarazo_deseado',
            'embarazo_planeado',
            'embarazo_aceptado',
            'fecha_pimera_eco',
            'gestacional_eco_1',
            'descripcion_eco_1',
            'fecha_segunda_eco',
            'gestacional_eco_2',
            'descripcion_eco_2',
            'fecha_tercera_eco',
            'gestacional_eco_3',
            'descripcion_eco_3',
            'gestacional_captacion',
            'violencia_1',
            'violencia_2',
            'violencia_3',
            'semana_nacimineto',
            'inconvenientes_lactancia',
            'plan_lactancia_retorno'
        ];

        $ginecobstetricos = HistoriaClinica::select($campos)
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->where(function ($query) use ($campos) {
                foreach ($campos as $campo) {
                    $query->orWhereNotNull($campo);
                }
            })
            ->latest('id')
            ->first();
        return $ginecobstetricos;
    }

    public function obtenerDatosValoracionPsicosocialDesarrollo($afiliadoId)
    {
        $valoracionPsicosocial = HistoriaClinica::select(
            'motricidad_gruesa',
            'motricidad_fina',
            'audicion_lenguaje',
            'personal_social',
            'cuidado',
            'escala_desarrollo',
            'autismo',
            'rendimiento_escolar',
            'test_figura_humana',
            'actividades',
            'autocontrol',
            'comportamientos',
            'auto_eficacia',
            'independencia',
            'control_interno',
            'funciones_ejecutivas',
            'identidad',
            'valoracion_identidad',
            'autonomia',
            'valoracion_autonomia',
            'funciones',
            'desempenio_comunicativo',
            'tamizaje_auditivo_neonatal',
            'resultado_vale',
            'factores_oido',
            'violencia_mental',
            'violencia_conflicto',
            'violencia_sexual',
            'lesiones_auto_inflingidas',
            'riesgos_mentales_ninos'
        )
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId)
                    ->whereHas('cita', function ($subQuery) {
                        $subQuery->where('tipo_historia_id', '!=', 1);
                    });
            })
            ->latest('id')
            ->first();
        return $valoracionPsicosocial;
    }

    public function obtenerDatosFindrisc($afiliadoId)
    {
        return HistoriaClinica::select(
            'historias_clinicas.imc',
            'historias_clinicas.perimetro_abdominal',
            'afiliados.sexo',
            'afiliados.edad_cumplida'
        )
            ->join('consultas', 'consultas.id', 'historias_clinicas.consulta_id')
            ->join('afiliados', 'afiliados.id', 'consultas.afiliado_id')
            ->where('afiliados.id', $afiliadoId)
            ->orderBy('historias_clinicas.id', 'desc')
            ->first();
    }

    function fetchCupCitologia($afiliado_id)
    {
        return CupGinecologico::with(['consultas', 'cup:id,nombre,codigo', 'usuarioCrea.operador:user_id,nombre,apellido'])->whereHas('consultas.afiliado', function ($q) use ($afiliado_id) {
            $q->where('afiliados.id', $afiliado_id);
        })->get();
    }

    function fetchCupMamografia($afiliado_id)
    {
        return CupMamografia::with(['consultas', 'cup:id,nombre,codigo', 'usuarioCrea.operador:user_id,nombre,apellido'])->whereHas('consultas.afiliado', function ($q) use ($afiliado_id) {
            $q->where('afiliados.id', $afiliado_id);
        })->get();
    }

    public function eliminarMamografia($id)
    {
        $resultado = CupMamografia::findOrFail($id);
        return $resultado->delete();
    }

    public function eliminarCupCitologia($id)
    {
        $resultado = CupGinecologico::findOrFail($id);
        return $resultado->delete();
    }

    /**
     * Retorna los signos vitales de una consulta
     * @param int $consultaId
     * @return HistoriaClinica
     * @author Thomas
     */
    public function consultarSignosVitalesConsulta(int $consultaId): HistoriaClinica
    {
        return HistoriaClinica::select([
            'peso',
            'frecuencia_respiratoria',
            'frecuencia_cardiaca',
            'temperatura',
            'presion_arterial_media',
            'presion_sistolica',
            'presion_diastolica'
        ])
            ->where('consulta_id', $consultaId)
            ->first();
    }

    public function buscarHistoriasCac(string $fecha_inicial, string $fecha_final, array $especialidades)
    {
        return HistoriaClinica::whereBetween('created_at', [$fecha_inicial, $fecha_final])
            ->whereHas('consulta', function ($query) use ($especialidades) {
                $query->whereIn('especialidad_id', $especialidades);
            })
            ->get();
    }
}
