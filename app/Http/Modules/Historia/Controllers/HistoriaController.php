<?php

namespace App\Http\Modules\Historia\Controllers;

use App\Formats\HistoriaClinicaIntegralBase;
use App\Http\Modules\Historia\EscalaAbreviadaDesarrollos\Models\EscalaAbreviadaDesarrollo;
use App\Http\Modules\Ordenamiento\Services\OrdenamientoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\AdmisionesUrgencias\Models\AdmisionesUrgencia;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Historia\Models\RedesApoyo;
use App\Http\Modules\Historia\Models\PlanCuidado;
use App\Http\Modules\Historia\Models\Familiograma;
use App\Http\Modules\Historia\Models\HistoriaClinica;
use App\Http\Modules\Historia\Models\PracticaCrianza;
use App\Http\Modules\Historia\Models\InformacionSalud;
use App\Http\Modules\Historia\Models\GestanteGinecologico;
use App\Http\Modules\Consultas\Repositories\ConsultaRepository;
use App\Http\Modules\Historia\Repositories\HistoricoRepository;
use App\Http\Modules\Cie10Afiliado\Repositories\Cie10AfiliadoRepository;
use App\Http\Modules\Historia\HistoriaRequest\crearCie10Request;
use App\Http\Modules\Historia\Models\AdherenciaFarmacoterapeutica;
use App\Http\Modules\Historia\Paraclinicos\Models\Paraclinico;
use App\Http\Modules\Historia\RegistroLaboratorios\Models\registroLaboratorios;
use App\Http\Modules\Historia\Services\HistoriaService;
use App\Http\Modules\Historia\Services\HistoricoService;
use App\Http\Requests\GenerarZipHistoriasRequest;
use App\Http\Services\ExcelService;
use App\Http\Services\HorusUnoService;
use App\Http\Services\S3Service;
use App\Jobs\GeneracionZipHistorias;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Modules\Historia\EscalaAbreviadaDesarrollos\Repositories\EscalaAbreviadaDesarrolloRepository;
use App\Http\Modules\PDF\Services\PdfService;
use App\Http\Services\ZipService;
use App\Jobs\ComprimirCarpeta;
use App\Jobs\FinalizarConsolidadoHistorias;
use App\Jobs\SubirArchivo;
use App\Mail\ZipHistoriasFallido;
use App\Mail\ZipHistoriasGenerado;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\TestStatus\Error;
use Throwable;

class HistoriaController extends Controller
{
    public function __construct(
        private HistoricoRepository $historicoRepository,
        private HorusUnoService $horusUnoService,
        private HistoricoService $historicoService,
        private Cie10AfiliadoRepository $cie10AfiliadoRepository,
        private ConsultaRepository $consultaRepository,
        private S3Service $s3Service,
        private ExcelService $excelService,
        private HistoriaClinicaIntegralBase $serviceHistoriaClinicaIntegralBase,
        protected HistoriaService $historiaService,
        private OrdenamientoService $ordenamientoService,
        private EscalaAbreviadaDesarrolloRepository $escalaAbreviadaDesarrolloRepository,
        protected PdfService $pdfService,
    ) {}

    public function historicoConsultas(Request $request)
    {
        $documento = $request->input('documento');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $defaultFechaInicio = '2024-05-01';

        $consulta = Consulta::select(
            'consultas.*',
            'historias_clinicas.id as historiaId',
            'historias_clinicas.destino_paciente as destinoPaciente',
            'historias_clinicas.finalidad_id',
            DB::raw('COALESCE(finalidad_consultas.nombre, historias_clinicas.finalidad) as finalidadConsulta')
        )
            ->with([
                "agenda",
                "afiliado",
                "agenda.cita.especialidad",
                "medicoOrdena.operador",
                "especialidad",
                'tipoConsulta',
                "cargueHistoriaContingencia.tipoArchivo",
                "recomendacionConsulta",
                "cita:id,nombre,tipo_historia_id"
            ])
            ->whereHas('afiliado', function ($q) use ($documento) {
                $q->where('numero_documento', $documento);
            })
            ->join('historias_clinicas', 'historias_clinicas.consulta_id', 'consultas.id')
            ->leftJoin('cargue_historia_contingencias', 'cargue_historia_contingencias.consulta_id', 'consultas.id')
            ->leftjoin('finalidad_consultas', 'historias_clinicas.finalidad_id', 'finalidad_consultas.id')
            ->whereNotIn('tipo_consulta_id', [1, 13, 14, 15, 16, 84])
            ->where('consultas.estado_id', 9)
            ->where('fecha_hora_inicio', '>', $defaultFechaInicio)
            ->orderBy('consultas.id', 'asc');

        // Aplicar filtro por fechas si se proporcionan
        if ($fechaInicio && $fechaFin) {
            $consulta->whereBetween('fecha_hora_inicio', [$fechaInicio, $fechaFin]);
        }

        $data = $request->page ? $consulta->paginate($request->cant) : $consulta->get();
        return response()->json($data, 200);
    }



    public function valoraciones($afiliadoId)
    {
        return response()->json(Cup::select('cups.nombre', 'cups.codigo', 'op.fecha_vigencia', 'c.afiliado_id')
            ->join('orden_procedimientos as op', 'cups.id', 'op.cup_id')
            ->join('ordenes as o', 'op.orden_id', 'o.id')
            ->join('consultas as c', 'o.consulta_id', 'c.id')
            ->join('users as u', 'c.medico_ordena_id', 'u.id')
            ->where('c.afiliado_id', $afiliadoId)
            ->whereIn('codigo', ['890206', '890207', '890208', '890209', '890276', '890297', '890306', '890307', '890308', '890309', '890376', '890397', '990105', '990205'])
            ->get());
    }

    public function registro($consultaId, $afiliado)
    {
        return response()->json(HistoriaClinica::where('consulta_id', $consultaId)->with([
            'consulta',
            'consulta.antecedenteFamiliares' => function ($query) use ($afiliado) {
                $query->whereHas('consulta.afiliado', function ($query) use ($afiliado) {
                    return $query->where('afiliados.id', $afiliado);
                });
            },
            'consulta.antecedentePersonales' => function ($query) use ($afiliado) {
                $query->whereHas('consulta.afiliado', function ($query) use ($afiliado) {
                    return $query->where('afiliados.id', $afiliado);
                });
            },
            'consulta.antecedenteTransfucionales' => function ($query) use ($afiliado) {
                $query->whereHas('consulta.afiliado', function ($query) use ($afiliado) {
                    return $query->where('afiliados.id', $afiliado);
                });
            },
            'consulta.vacunacion' => function ($query) use ($afiliado) {
                $query->whereHas('consulta.afiliado', function ($query) use ($afiliado) {
                    return $query->where('afiliados.id', $afiliado);
                });
            },
            'consulta.antecedenteQuirurgicos' => function ($query) use ($afiliado) {
                $query->whereHas('consulta.afiliado', function ($query) use ($afiliado) {
                    return $query->where('afiliados.id', $afiliado);
                });
            },
            'consulta.apgarFamiliar' => function ($query) use ($afiliado) {
                $query->whereHas('consulta.afiliado', function ($query) use ($afiliado) {
                    return $query->where('afiliados.id', $afiliado);
                });
            },
            'consulta.resultadoLaboratorios' => function ($query) use ($afiliado) {
                $query->whereHas('consulta.afiliado', function ($query) use ($afiliado) {
                    return $query->where('afiliados.id', $afiliado);
                });
            },
            'consulta.antecedenteHospitalarios',
            'consulta.antecedenteFamiliograma',
            'consulta.cie10Afiliado',
            'consulta.antecedenteEcomapa',
        ])->first());
    }

    public function guardar($consultaId, Request $request)
    {

        HistoriaClinica::updateOrCreate(['consulta_id' => $consultaId], $request->except(['consulta']));
        return response()->json(['mensaje' => 'Registro Guardado!']);
    }

    public function historiaPlanCuidado(Request $request)
    {
        $planManejo = PlanCuidado::whereHas('consulta.afiliado', function ($q) use ($request) {
            $q->where('afiliados.id', $request->afiliado);
        })->get();
        $informacionSalud = InformacionSalud::whereHas('consulta.afiliado', function ($q) use ($request) {
            $q->where('afiliados.id', $request->afiliado);
        })->get();
        $practicaCrianza = PracticaCrianza::whereHas('consulta.afiliado', function ($q) use ($request) {
            $q->where('afiliados.id', $request->afiliado);
        })->get();
        $datos = [
            'PlanCuidado' => $planManejo,
            'InformacionSalud' => $informacionSalud,
            'PracticaCrianza' => $practicaCrianza
        ];
        return response()->json($datos);
    }

    public function guardarPlanCuidado($consultaId, Request $request)
    {
        PlanCuidado::create([
            'consulta_id' => $consultaId,
            'plan' => $request['plan']['nombre'],
        ]);
        $rep = $request->rep_id;
        $articulos = array_map(function ($data) use ($rep) {
            return [
                'articulo' => $data,
                'meses' => $data['meses'],
                'cantidadMedico' => $data['cantidad_medico'],
                'dosis' => $data['dosis'],
                'frecuencia' => $data['frecuencia'],
                'duracion' => $data['duracion'],
                'tiempo' => $data['unidad_tiempo'],
                'descripcion' => $data['dosis'] . ' ' . $data['presentacion'] . ' ' . $data['via'] . ' cada ' . $data['frecuencia'] . ' ' . $data['unidad_tiempo'] . ' por ' . $data['duracion'] . ' días',
                'observacion' => $data['observacion'],
                'rep_id' => $rep
            ];
        }, $request->plan['articulos']);
        $this->ordenamientoService->generarOrden($consultaId, 1, $articulos);

        return response()->json("Datos Guardados!");
    }

    public function eliminarRegistroPlanCuidado($tipo, $id)
    {
        switch (intval($tipo)) {
            case 1:
                PlanCuidado::destroy($id);
                break;
            case 2:
                InformacionSalud::destroy($id);
                break;
            case 3:
                PracticaCrianza::destroy($id);
                break;
        }
        return response()->json("Dato Eliminado!");
    }

    public function historiaGestanteGinecologicos($consultaId)
    {
        return response()->json(
            GestanteGinecologico::where('consulta_id', $consultaId)->get()
        );
    }

    public function guardarGestanteGinecologico($consultaId, Request $request)
    {
        GestanteGinecologico::create([
            'consulta_id' => $consultaId,
            'patologia' => $request['patologias'],
            'presente' => $request['presente'],
            'fecha_patologia' => $request['fecha_patologia']
        ]);
        return response()->json("Datos Guardados!");
    }

    public function eliminarGestanteGinecologico($id)
    {
        GestanteGinecologico::destroy($id);
        return response()->json("Dato Eliminado!");
    }

    public function historiaRedesApoyos($consultaId)
    {
        return response()->json(
            RedesApoyo::where('consulta_id', $consultaId)->get()
        );
    }

    public function guardarRedApoyo($consultaId, Request $request)
    {
        RedesApoyo::create([
            'consulta_id' => $consultaId,
            'red' => $request['red'],
            'activo' => $request['activo'],
            'club' => $request['club'],
            'observacion' => $request['observacion'],
        ]);
    }

    public function eliminarRedApoyo($id)
    {
        RedesApoyo::destroy($id);
        return response()->json("Dato Eliminado!");
    }

    public function historiaFamiliograma($consultaId)
    {
        return response()->json(
            Familiograma::where('consulta_id', $consultaId)->get()
        );
    }

    public function guardarFamiliograma($consultaId, Request $request)
    {
        Familiograma::create([
            'consulta_id' => $consultaId,
            'vinculos' => $request['vinculos'],
            'relacion_afectiva' => $request['relacion_afectiva'],
            'problemas_salud' => $request['problemas_salud'],
            'cual_familiograma' => $request['cual_familiograma'],
            'observaciones_familiograma' => $request['observaciones_familiograma'],
        ]);
    }

    public function eliminarFamiliograma($id)
    {
        Familiograma::destroy($id);
        return response()->json("Dato Eliminado!");
    }

    public function finalizarHistoria($consultaId)
    {
        $tieneDiagnosticos = $this->cie10AfiliadoRepository->verificarDiagnosticosAsociados($consultaId);

        if (!$tieneDiagnosticos) {
            return response()->json(['error' => 'No se puede finalizar la historia porque no hay diagnósticos asociados, debes asociar por lo menos un diagnóstico a la consulta'], 400);
        }
        $finalidad = $this->historiaService->verificarFinalidad($consultaId);
        if (!$finalidad) {
            return response()->json(['error' => 'No se puede finalizar la historia porque no hay finalidades o causas externas, debes asociar por lo menos una finalidad y una causa a la consulta'], 400);
        }
        $consulta = Consulta::find($consultaId);
        if (!$consulta) {
            return response()->json(['error' => 'Consulta no encontrada.'], 404);
        }
        if ($consulta->estado_triage) {
            AdmisionesUrgencia::where('id', $consulta->admision_urgencia_id)->update(['estado_id' => 60]);
        }
        $consulta->estado_id = 9;
        $consulta->hora_fin_atendio_consulta = Carbon::now();
        $consulta->medico_ordena_id = auth()->id();
        $consulta->save();
        $this->consultaRepository->actualizarEstadoGestion($consulta->id, 51);
        return response()->json(['mensaje' => 'Consulta finalizada correctamente.']);
    }

    public function concluirNoFinalizada($consultaId)
    {
        $tieneDiagnosticos = $this->cie10AfiliadoRepository->verificarDiagnosticosAsociados($consultaId);

        if (!$tieneDiagnosticos) {
            return response()->json(['error' => 'No se puede finalizar la historia porque no hay diagnósticos asociados, debes asociar por lo menos un diagnóstico a la consulta'], 400);
        }

        $consulta = Consulta::find($consultaId);
        if (!$consulta) {
            return response()->json(['error' => 'Consulta no encontrada.'], 404);
        }

        // Convertir la hora de inicio y el tiempo de consulta a objetos Carbon
        $horaInicio = Carbon::parse($consulta->hora_inicio_atendio_consulta);
        $tiempoConsulta = Carbon::parse($consulta->tiempo_consulta);

        // Sumar el tiempo de consulta a la hora de inicio
        $horaFin = $horaInicio->addHours($tiempoConsulta->hour)
            ->addMinutes($tiempoConsulta->minute)
            ->addSeconds($tiempoConsulta->second);

        // Actualizar la consulta con la nueva hora de fin y otros valores
        $consulta->estado_id = 9;
        $consulta->hora_fin_atendio_consulta = $horaFin;
        $consulta->medico_ordena_id = auth()->id();
        $consulta->save();

        return response()->json(['mensaje' => 'Consulta finalizada correctamente.']);
    }


    public function examenFisico(Request $request)
    {
        try {
            $antecedentes = $this->historicoRepository->examenFisico($request);
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los antecedentes quirurgicos'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function guardarCie10(crearCie10Request $request)
    {
        try {
            $antecedentes = $this->cie10AfiliadoRepository->crearCie10Consulta($request->validated());
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarCie10Historico(Request $request)
    {
        try {
            $antecedentes = $this->cie10AfiliadoRepository->listarCie10Historico($request);
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los antecedentes quirurgicos'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function inasistir(Request $request)
    {
        try {
            $consulta = $this->consultaRepository->inasistir($request);
            return response()->json($consulta);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function enconsulta($consultaId)
    {
        try {
            $consulta = $this->consultaRepository->enconsulta($consultaId);
            return response()->json($consulta);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarTiempo(Request $request)
    {
        try {
            $consulta = $this->consultaRepository->actualizarTiempo($request);
            return response()->json($consulta);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function contadores(Request $request)
    {
        try {
            $consulta = $this->historicoRepository->contadores($request);
            return response()->json($consulta);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function repositorioHistorias(Request $request)
    {

        try {
            $consulta = $this->historicoService->historicoHistorias($request);
            return response()->json($consulta);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function validacionHistoria(Request $request)
    {
        try {
            $consulta = $this->consultaRepository->validacionHistoria($request);
            return response()->json($consulta);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    public function datosParaclinicos($afiliado_id)
    {
        $creatinina = RegistroLaboratorios::select('registro_laboratorios.id as idCreatina', 'registro_laboratorios.resultado as resultadoCreatinina', 'registro_laboratorios.fecha_validacion as ultimaCreatinina')
            ->where('registro_laboratorios.afiliado_id', $afiliado_id)
            ->whereIn('registro_laboratorios.codigo_cup', [903895])
            ->orderBy('registro_laboratorios.id', 'asc')->take(1)->first();

        $hdl = RegistroLaboratorios::select('registro_laboratorios.id as idHdl', 'registro_laboratorios.resultado as resultadoHdl', 'registro_laboratorios.fecha_validacion as fechaHdl')
            ->where('registro_laboratorios.afiliado_id', $afiliado_id)
            ->whereIn('registro_laboratorios.codigo_cup', [903815])
            ->orderBy('registro_laboratorios.id', 'asc')->take(1)->first();

        $albuminuria = RegistroLaboratorios::select('registro_laboratorios.id as idAlbuminuria', 'registro_laboratorios.resultado as resultadoAlbuminuria', 'registro_laboratorios.fecha_validacion as fechaAlbuminuria')
            ->where('registro_laboratorios.afiliado_id', $afiliado_id)
            ->whereIn('registro_laboratorios.codigo_cup', [903027])
            ->orderBy('registro_laboratorios.id', 'asc')->take(1)->first();

        $hemoglobina = RegistroLaboratorios::select('registro_laboratorios.id as idHemoglobina', 'registro_laboratorios.resultado as resultaGlicosidada', 'registro_laboratorios.fecha_validacion as fechaGlicosidada')
            ->where('registro_laboratorios.afiliado_id', $afiliado_id)
            ->whereIn('registro_laboratorios.codigo_cup', [903426])
            ->orderBy('registro_laboratorios.id', 'asc')->take(1)->first();

        $colesterolTotal = RegistroLaboratorios::select('registro_laboratorios.id as idRegistoColesterol', 'registro_laboratorios.resultado as resultadoColesterol', 'registro_laboratorios.fecha_validacion as fechaColesterol')
            ->where('registro_laboratorios.afiliado_id', $afiliado_id)
            ->whereIn('registro_laboratorios.codigo_cup', [903818])
            ->orderBy('registro_laboratorios.id', 'asc')->take(1)->first();

        $trigliceridos = RegistroLaboratorios::select('registro_laboratorios.id as idTrigliceridos', 'registro_laboratorios.resultado as resultadoTrigliceridos', 'registro_laboratorios.fecha_validacion as fechaTrigliceridos')
            ->where('registro_laboratorios.afiliado_id', $afiliado_id)
            ->whereIn('registro_laboratorios.codigo_cup', [903868])
            ->orderBy('registro_laboratorios.id', 'asc')->take(1)->first();

        $glicemia = RegistroLaboratorios::select('registro_laboratorios.id as idGlicemia', 'registro_laboratorios.resultado as resultadoGlicemia', 'registro_laboratorios.fecha_validacion as fechaGlicemia')
            ->where('registro_laboratorios.afiliado_id', $afiliado_id)
            ->whereIn('registro_laboratorios.codigo_cup', [903841])
            ->orderBy('registro_laboratorios.id', 'asc')->take(1)->first();

        $pht = RegistroLaboratorios::select('registro_laboratorios.id as idPht', 'registro_laboratorios.resultado as resultadoPht', 'registro_laboratorios.fecha_validacion as fechaPht')
            ->where('registro_laboratorios.afiliado_id', $afiliado_id)
            ->whereIn('registro_laboratorios.codigo_cup', [904912])
            ->orderBy('registro_laboratorios.id', 'asc')->take(1)->first();

        $albumina = RegistroLaboratorios::select('registro_laboratorios.id as idAlbumina', 'registro_laboratorios.resultado as albumina', 'registro_laboratorios.fecha_validacion as fechaAlbumina')
            ->where('registro_laboratorios.afiliado_id', $afiliado_id)
            ->whereIn('registro_laboratorios.codigo_cup', [903803])
            ->orderBy('registro_laboratorios.id', 'asc')->take(1)->first();

        $fosforo = RegistroLaboratorios::select('registro_laboratorios.id as idFosforo', 'registro_laboratorios.resultado as fosforo', 'registro_laboratorios.fecha_validacion as fechaFosforo')
            ->where('registro_laboratorios.afiliado_id', $afiliado_id)
            ->whereIn('registro_laboratorios.codigo_cup', [903835])
            ->orderBy('registro_laboratorios.id', 'asc')->take(1)->first();

        $array = [
            'creatinina' => $creatinina,
            'hdl' => $hdl,
            'albuminuria' => $albuminuria,
            'hemoglobina' => $hemoglobina,
            'colesterolTotal' => $colesterolTotal,
            'trigliceridos' => $trigliceridos,
            'glicemia' => $glicemia,
            'pht' => $pht,
            'albumina' => $albumina,
            'fosforo' => $fosforo,
        ];

        return response()->json($array, 200);
    }

    public function guardarParaclinico($request)
    {
        $request['usuario_id'] = auth()->user()->id;
        Paraclinico::create([
            'resultadoCreatinina' => $request['resultadoCreatinina'],
            'ultimaCreatinina' => $request['ultimaCreatinina'],
            'resultaGlicosidada' => $request['resultaGlicosidada'],
            'fechaGlicosidada' => $request['fechaGlicosidada'],
            'resultadoAlbuminuria' => $request['resultadoAlbuminuria'],
            'fechaAlbuminuria' => $request['fechaAlbuminuria'],
            'fechaColesterol' => $request['fechaColesterol'],
            'resultadoHdl' => $request['resultadoHdl'],
            'fechaHdl' => $request['fechaHdl'],
            'resultadoLdl' => $request['resultadoLdl'],
            'fechaLdl' => $request['fechaLdl'],
            'resultadoTrigliceridos' => $request['resultadoTrigliceridos'],
            'fechaTrigliceridos' => $request['fechaTrigliceridos'],
            'resultadoGlicemia' => $request['resultadoGlicemia'],
            'fechaGlicemia' => $request['fechaGlicemia'],
            'resultadoPht' => $request['resultadoPht'],
            'fechaPht' => $request['fechaPht'],
            'resultadoHemoglobina' => $request['resultadoHemoglobina'],
            'albumina' => $request['albumina'],
            'fechaAlbumina' => $request['fechaAlbumina'],
            'fosforo' => $request['fosforo'],
            'fechaFosforo' => $request['fechaFosforo'],
            'resultadoEkg' => $request['resultadoEkg'],
            'fechaEkg' => $request['fechaEkg'],
            'glomerular' => $request['glomerular'],
            'fechaGlomerular' => $request['fechaGlomerular'],
            'usuario_id' => $request['usuario_id'],
            'afiliado_id' => $request['afiliado_id'],
            'consulta_id' => $request['consulta_id'],
            'nombreParaclinico' => $request['nombreParaclinico'],
            'resultadoParaclinico' => $request['resultadoParaclinico'],
            'checkboxParaclinicos' => $request['checkboxParaclinicos'],
            'fechaParaclinico' => $request['fechaParaclinico'],
        ]);
        registroLaboratorios::where('id', $request['idRegistoColesterol'])
            ->update([
                'resultado' => $request->resultadoColesterol,
                'fecha_validacion' => $request->fechaColesterol
            ]);
        RegistroLaboratorios::where('id', $request['idHdl'])
            ->update([
                'resultado' => $request->resultadoHdl,
                'fecha_validacion' => $request->fechaHdl
            ]);
        RegistroLaboratorios::where('id', $request['idTrigliceridos'])
            ->update([
                'resultado' => $request->resultadoTrigliceridos,
                'fecha_validacion' => $request->fechaTrigliceridos
            ]);
        RegistroLaboratorios::where('id', $request['idCreatina'])
            ->update([
                'resultado' => $request->resultadoCreatinina,
                'fecha_validacion' => $request->ultimaCreatinina
            ]);
        RegistroLaboratorios::where('id', $request['idAlbuminuria'])
            ->update([
                'resultado' => $request->resultadoAlbuminuria,
                'fecha_validacion' => $request->fechaAlbuminuria
            ]);
        RegistroLaboratorios::where('id', $request['idHemoglobina'])
            ->update([
                'resultado' => $request->resultaGlicosidada,
                'fecha_validacion' => $request->fechaGlicosidada
            ]);
        RegistroLaboratorios::where('id', $request['idGlicemia'])
            ->update([
                'resultado' => $request->resultadoGlicemia,
                'fecha_validacion' => $request->fechaGlicemia
            ]);
        RegistroLaboratorios::where('id', $request['idPht'])
            ->update([
                'resultado' => $request->resultadoPht,
                'fecha_validacion' => $request->fechaPht
            ]);
        RegistroLaboratorios::where('id', $request['idAlbumina'])
            ->update([
                'resultado' => $request->albumina,
                'fecha_validacion' => $request->fechaAlbumina
            ]);
        RegistroLaboratorios::where('id', $request['idFosforo'])
            ->update([
                'resultado' => $request->fosforo,
                'fecha_validacion' => $request->fechaFosforo
            ]);
        return response()->json([
            'message' => 'Paraclinicos guardado con exito!'
        ], 200);
    }

    public function saveAdherenciaFarmacologica(Request $request)
    {
        $adherencia = AdherenciaFarmacoterapeutica::where('consulta_id', $request['consulta_id'])->first();
        if (!$adherencia) {
            $request['user_id'] = auth()->user()->id;
            AdherenciaFarmacoterapeutica::create($request->all());
            return response()->json([
                'message' => 'Adherencia Farmacoterapeutica guardada con exito!'
            ], 200);
        } else {
            $adherencia->update($request->except(['consulta_id']));
            return response()->json([
                'message' => 'Adherencia Farmacoterapeutica actualizada con exito!'
            ], 200);
        }
    }

    public function eliminarCie10(Request $request)
    {
        try {
            $cie10afi = $this->cie10AfiliadoRepository->eliminarCie10Afi($request);
            return response()->json($cie10afi);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los antecedentes quirurgicos'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * consulta las historias de horus uno
     * @param Request $request
     */
    public function historiasV1(Request $request, $documento_afiliado)
    {
        try {
            $data = $this->horusUnoService->getHistorias($documento_afiliado);
            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * obteiene el base 64 de un archivo pdf de historias en horus uno
     * @param Request $request
     */
    public function pdfHorusUno(Request $request)
    {
        try {
            $data = $this->horusUnoService->getBase64($request->data);
            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }


    /**
     * obteiene el base 64 de un archivo x de horus uno
     * @param Request $request
     */
    public function adjuntoHorusUno(Request $request)
    {
        try {
            $data = $this->horusUnoService->getBase64Adjunto($request->data);
            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Obtiene las historias de sumidental
     * @param Request $request
     * @author David Peláez
     * @edit kobatime
     */
    public function historiasSumidental(Request $request, $documento)
    {
        try {
            $historias = $this->s3Service->getHistorias($documento, $request->carpeta);
            return response()->json($historias);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Genera un empaquetado de los pdfs de cada documento llegado en el excel
     * @param Request $request
     * @return Response
     * @author David Peláez
     */
    public function generarZipHistorias(GenerarZipHistoriasRequest $request)
    {
        try {
            # obtenemos las columnas del excel
            $afiliados = $this->excelService->getColumnas($request->file('file'), ['documento', 'tipo_documento']);
            # generamos una carpeta Unica par el consolidado
            $carpetaStorage = storage_path('app/tmp/' . uniqid('consolidado_historias_'));
            # creamos la carpeta
            mkdir($carpetaStorage, 0777, true);
            # obtenemos el usuario autenticado
            $authUser = auth()->user();
            $data = $request->validated();
            unset($data['file']);
            $jobs = [];
            foreach ($afiliados->toArray() as $afiliado) {
                $jobs[] = (new GeneracionZipHistorias($afiliado, $data, $carpetaStorage))->onQueue('pesado');
            }
            Bus::batch($jobs)
                ->then(function (Batch $batch) use ($carpetaStorage, $authUser) {
                    Bus::chain([
                        new ComprimirCarpeta($carpetaStorage),
                        //new SubirArchivo($carpetaStorage . '.zip', 'paquetes/historias/'),
                        //new FinalizarConsolidadoHistorias($carpetaStorage . '.zip', 'paquetes/historias/', $authUser->email)
                    ])
                        ->onQueue('pesado')
                        ->dispatch();
                })
                ->catch(function (Batch $batch, Throwable $e) use ($carpetaStorage, $authUser) {
                    # eliminamos la carpeta temporal
                    if (is_dir(storage_path('app/' . $carpetaStorage))) {
                        foreach (glob(storage_path('app/' . $carpetaStorage . '/*')) as $file) {
                            is_dir($file) ? $this->deleteFolder($file) : unlink($file);
                        }
                        rmdir(storage_path('app/' . $carpetaStorage));
                    }
                    # eliminamos el zip
                    if (file_exists(storage_path('app/' . $carpetaStorage . '.zip'))) {
                        unlink(storage_path('app/' . $carpetaStorage . '.zip'));
                    }
                    //Mail::to($authUser->email)->send(new ZipFormulasError($fecha));
                })
                ->name('Consolidado de Historias')
                ->dispatch();
            return response()->json(true);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function obtenerDatosBarthel($afiliadoId)
    {
        try {
            $barthel = $this->historicoRepository->obtenerDatosBarthel($afiliadoId);
            return response()->json($barthel, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function obtenerDatosKarnosfki($afiliadoId)
    {
        try {
            $karnosfki = $this->historicoRepository->obtenerDatosKarnosfki($afiliadoId);
            return response()->json($karnosfki, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function datosEcog($afiliadoId)
    {
        try {
            $datosecog = $this->historicoRepository->obtenerDatosEcog($afiliadoId);
            return response()->json($datosecog, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edmonEsas($afiliadoId)
    {
        try {
            $datosEsas = $this->historicoRepository->edmontonEsas($afiliadoId);
            return response()->json($datosEsas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function estiloVida($afiliadoId)
    {
        try {
            $datos = $this->historicoRepository->estiloVida($afiliadoId);
            return response()->json($datos, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function obtenerDatosGinecobstetricos($afiliadoId)
    {
        try {
            $gineco = $this->historicoRepository->obtenerDatosGinecobstetricos($afiliadoId);
            return response()->json($gineco, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function obtenerDatosValoracionPsicosocial($afiliadoId)
    {
        try {
            $pisocosocial = $this->historicoRepository->obtenerDatosValoracionPsicosocialDesarrollo($afiliadoId);
            return response()->json($pisocosocial, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function obtenerDatosFindric($afiliadoId)
    {
        try {
            $findrisc = $this->historicoRepository->obtenerDatosFindrisc($afiliadoId);
            return response()->json($findrisc);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function cupCitologia(Request $request, $consulta_id)
    {
        try {
            $cupCitologia = $this->historiaService->cupCitologia($consulta_id, $request);
            return response()->json($cupCitologia);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function cupMamografia(Request $request, $consulta_id)
    {
        try {
            $cupMamografia = $this->historiaService->cupMamografia($consulta_id, $request);
            return response()->json($cupMamografia);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function fetchcupCitologia(int $afiliado_id)
    {
        try {
            $cupCitologia = $this->historicoRepository->fetchCupCitologia($afiliado_id);
            return response()->json($cupCitologia);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function fetchcupMamografia(int $afiliado_id)
    {
        try {
            $cupCitologia = $this->historicoRepository->fetchCupMamografia($afiliado_id);
            return response()->json($cupCitologia);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function eliminarMamomgrafia($id)
    {
        try {
            $mamografia = $this->historicoRepository->eliminarMamografia($id);
            return response()->json($mamografia);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), 400]);
        }
    }

    public function eliminarCitologia($id)
    {
        try {
            $citologia = $this->historicoRepository->eliminarCupCitologia($id);
            return response()->json($citologia);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function actualizarImpresion($id, Request $request)
    {
        try {
            $impresion = $this->historiaService->actualizarImpresion($id, $request->all());
            return response()->json($impresion);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), 400]);
        }
    }

    public function guardarEscalaAbreviada($id, Request $request)
    {
        try {
            $this->historiaService->guardarEscalaAbreviada($id, $request->all());
            return response()->json(['mensaje' => 'Datos Guardados!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), 400]);
        }
    }

    public function listarEscalaAbreviada($id)
    {
        try {
            $escalaAbreviada = $this->escalaAbreviadaDesarrolloRepository->listarEscala($id);
            return response()->json($escalaAbreviada);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function crearNeuropsicologia(Request $request)
    {
        try {
            $neuro = $this->historiaService->crearNeuropsicologia($request->all());
            return response()->json($neuro);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function obtenerDatos($afiliadoId)
    {
        try {
            $neuro = $this->historiaService->obtenerDatosNeuropsicologia($afiliadoId);
            return response()->json($neuro);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function finalizarHistoriaUrgencias($consultaId)
    {
        try {
            $consulta = $this->historiaService->finalizarHistoriaUrgencias($consultaId);
            return response()->json($consulta);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * finalizarHistoriaClinica
     * @param Request $request
     * @param  mixed $consulta_id
     * @param  mixed $request
     * @return void
     */
    public function finalizarHistoriaClinica($consulta_id, Request $request)
    {
        try {
            $historia = $this->historiaService->finalizarHistoriaClinica($consulta_id, $request->all());
            return response()->json($historia);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Consulta los signos vitales de una HC por consulta ID
     * @param int $consultaId
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function consultarSignosVitalesConsulta(int $consultaId): JsonResponse
    {
        try {
            $response = $this->historicoRepository->consultarSignosVitalesConsulta($consultaId);
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function combinacionPDFs(Request $request)
    {
        try {
            $archivos = [
                storage_path('app/temp/pdf1.pdf'),
                storage_path('app/temp/pdf2.pdf'),
            ];
            $salida = storage_path('app/public/pdf_unido.pdf');
            $this->pdfService->combinarPDFs($archivos, $salida);
            return response()->json(['mensaje' => 'Combinacion de pdfs exitosa']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
