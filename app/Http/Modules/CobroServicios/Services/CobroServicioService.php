<?php

namespace App\Http\Modules\CobroServicios\Services;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Afiliados\Repositories\AfiliadoRepository;
use App\Http\Modules\Agendas\Models\Agenda;
use App\Http\Modules\Auditorias\Models\Auditoria;
use App\Http\Modules\Cie10Afiliado\Models\Cie10Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Consultas\Models\ConsultaOrdenProcedimientos;
use App\Http\Modules\Consultas\Repositories\ConsultaRepository;
use App\Http\Modules\Contratos\Models\CobroServicio;
use App\Http\Modules\Contratos\Models\Contrato;
use App\Http\Modules\Contratos\Repositories\CobroServicioRepository;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Cups\Services\CupService;
use App\Http\Modules\GestionOrdenPrestador\Models\GestionOrdenPrestador;
use App\Http\Modules\GestionOrdenPrestador\Repositories\AdjuntoGestionOrdenRepository;
use App\Http\Modules\LogsKeiron\Services\KeironService;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Ordenamiento\Models\OrdenCodigoPropio;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Modules\Prestadores\Models\Prestador;
use App\Http\Modules\Prestadores\Repositories\PrestadorRepository;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Services\facturacionElectronicaService;
use App\Http\Services\SismaService;
use App\Traits\ArchivosTrait;
use Carbon\Carbon;

class CobroServicioService
{

    use ArchivosTrait;

    public function __construct(
        protected CobroServicioRepository $cobroServicioRepository,
        protected AdjuntoGestionOrdenRepository $AdjuntoGestionOrdenRepository,
        private KeironService $keironService,
        protected ConsultaRepository $consultaRepository,
        protected AfiliadoRepository $afiliadoRepository,
        protected SismaService $sismaService,
        protected PrestadorRepository $prestadorRepository,
        protected CupService $cupService,
        protected facturacionElectronicaService $facturacionElectronicaService
    ) {
    }

    public function registrarCobro($cobroServicio, $request)
    {
        $datos = $request;
        $datos['estado_id'] = 14;
        $datos['usuario_cobra'] = auth()->id();
        $datos['fecha_cobro'] = date('Y-m-d');
        $cobroServicio = $this->cobroServicioRepository->buscar($cobroServicio);
        $this->cobroServicioRepository->actualizar($cobroServicio, $datos);
        if ($cobroServicio->orden_procedimiento_id || $cobroServicio->orden_codigo_propio_id) {
            $datosGestion = [
                'fecha_resultado' => null,
                'funcionario_responsable' => null,
                'cirujano' => null,
                'especialidad' => null,
                'fecha_preanestesia' => null,
                'fecha_cirugia' => null,
                'estado' => 51,
                'observaciones' => 'Registro creado por admisiones',
                'fecha_ejecucion' => date('Y-m-d'),
                'fecha_asistencia' => date('Y-m-d'),
                'tipoOrden' => $cobroServicio->orden_procedimiento_id ? 'servicio' : 'codigo-propio',
                'id' => $cobroServicio->orden_procedimiento_id ?: $cobroServicio->orden_codigo_propio_id,
            ];
            $this->enviarDetalle($datosGestion);
        }
        return true;
    }

    public function enviarDetalle($request)
    {
        $estado = $request['estado'];

        switch (intval($estado)) {
            case 51:
                $nuevaGestion = new GestionOrdenPrestador();

                if ($request['tipoOrden'] == 'servicio') {
                    $nuevaGestion['orden_procedimiento_id'] = $request['id'];

                    $ordenProcedimiento = OrdenProcedimiento::find($request['id']);
                    $ordenProcedimiento['estado_id_gestion_prestador'] = $estado;
                    $ordenProcedimiento['estado_id'] = 54;

                    $ordenProcedimiento->save();
                } else {
                    $nuevaGestion['orden_codigo_propio_id'] = $request['id'];

                    $ordenCodigoPropio = OrdenCodigoPropio::find($request['id']);
                    $ordenCodigoPropio['estado_id_gestion_prestador'] = $estado;
                    $ordenCodigoPropio['estado_id'] = 54;
                    $ordenCodigoPropio->save();
                }

                $nuevaGestion['estado_gestion_id'] = $request['estado'];
                // $nuevaGestion['fecha_sugerida'] = $request['fecha_sugerida'];
                // $nuevaGestion['fecha_solicita_afiliado'] = $request['fecha_solicitada_afiliado'];
                $nuevaGestion['fecha_resultado'] = $request['fecha_resultado'];
                $nuevaGestion['observacion'] = $request['observaciones'];
                $nuevaGestion['funcionario_responsable'] = $request['funcionario_responsable'];
                $nuevaGestion['funcionario_gestiona'] = auth()->user()->id;
                $nuevaGestion['cirujano'] = $request['cirujano'];
                $nuevaGestion['especialidad'] = $request['especialidad'];
                $nuevaGestion['fecha_preanestesia'] = $request['fecha_preanestesia'];
                $nuevaGestion['fecha_cirugia'] = $request['fecha_cirugia'];
                $nuevaGestion['fecha_ejecucion'] = $request['fecha_ejecucion'];
                $nuevaGestion['fecha_asistencia'] = $request['fecha_asistencia'];
                $nuevaGestion->save();
                if (isset($request['adjuntos'])) {
                    $archivos = $request['adjuntos'];
                    $ruta = 'adjuntosGestionOrden/' . $request['id'] . '/asistencia';

                    foreach ($archivos as $archivo) {
                        $nombre = $archivo->getClientOriginalName();
                        $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
                        $adjunto = $this->AdjuntoGestionOrdenRepository->crear([
                            'nombre' => $nombre,
                            'ruta' => $subirArchivo,
                            'gestion_orden_id' => $nuevaGestion->id
                        ]);
                    }
                }
                break;
            case 30:
                $nuevaGestion = new GestionOrdenPrestador();

                if ($request['tipoOrden'] == 'servicio') {
                    $nuevaGestion['orden_procedimiento_id'] = $request['id'];
                    $ordenProcedimiento = OrdenProcedimiento::find($request['id']);
                    $ordenProcedimiento['estado_id_gestion_prestador'] = 50;
                    $ordenProcedimiento->save();
                    $ordenConsulta = ConsultaOrdenProcedimientos::where('orden_procedimiento_id', $request['id'])->first();
                    if ($ordenConsulta) {
                        $consulta = Consulta::find($ordenConsulta->consulta_id);
                        $datos = [
                            'consulta' => $consulta->id,
                            'afiliado' => $consulta->afiliado_id,
                            'motivoCancelacion' => ($request['motivo_cancelacion'] ?: $request['causa_cancelacion'])
                        ];
                        $this->cancelar($datos);
                    }
                } else {
                    $nuevaGestion['orden_codigo_propio_id'] = $request['id'];
                    $ordenCodigoPropio = OrdenCodigoPropio::find($request['id']);
                    $ordenCodigoPropio['estado_id_gestion_prestador'] = 50;
                    $ordenCodigoPropio->save();
                    $ordenConsulta = ConsultaOrdenProcedimientos::where('orden_codigo_propio_id', $request['id'])->first();
                    if ($ordenConsulta) {
                        $consulta = Consulta::find($ordenConsulta->consulta_id);
                        $datos = [
                            'consulta' => $consulta->id,
                            'afiliado' => $consulta->afiliado_id,
                            'motivoCancelacion' => ($request['motivo_cancelacion'] ?: $request['causa_cancelacion'])
                        ];
                        $this->cancelar($datos);
                    }
                }
                $nuevaGestion['estado_gestion_id'] = $request['estado'];
                $nuevaGestion['observacion'] = $request['observaciones'];
                $nuevaGestion['funcionario_responsable'] = $request['funcionario_responsable'];
                $nuevaGestion['funcionario_gestiona'] = auth()->user()->id;
                $nuevaGestion['fecha_cancelacion'] = $request['fecha_cancelacion'];
                $nuevaGestion['motivo_cancelacion'] = $request['motivo_cancelacion'];
                $nuevaGestion['causa_cancelacion'] = $request['causa_cancelacion'];
                $nuevaGestion->save();
                if (isset($request['adjuntos'])) {
                    $archivos = $request['adjuntos'];
                    $ruta = 'adjuntosGestionOrden/' . $request['id'] . '/cancelada';

                    foreach ($archivos as $archivo) {
                        $nombre = $archivo->getClientOriginalName();
                        $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
                        $adjunto = $this->AdjuntoGestionOrdenRepository->crear([
                            'nombre' => $nombre,
                            'ruta' => $subirArchivo,
                            'gestion_orden_id' => $nuevaGestion->id
                        ]);
                    }
                }
                break;
            case 8:
                $nuevaGestion = new GestionOrdenPrestador();

                if ($request['tipoOrden'] == 'servicio') {
                    $nuevaGestion['orden_procedimiento_id'] = $request['id'];

                    $ordenProcedimiento = OrdenProcedimiento::find($request['id']);
                    $ordenProcedimiento['estado_id_gestion_prestador'] = $estado;
                    $ordenProcedimiento->save();
                } else {
                    $nuevaGestion['orden_codigo_propio_id'] = $request['id'];

                    $ordenCodigoPropio = OrdenCodigoPropio::find($request['id']);
                    $ordenCodigoPropio['estado_id_gestion_prestador'] = $estado;
                    $ordenCodigoPropio->save();
                }

                $nuevaGestion['estado_gestion_id'] = $request['estado'];
                $nuevaGestion['observacion'] = $request['observaciones'];
                $nuevaGestion['funcionario_responsable'] = $request['funcionario_responsable'];
                $nuevaGestion['funcionario_gestiona'] = auth()->user()->id;
                $nuevaGestion->save();


                break;
            case 52:
                $nuevaGestion = new GestionOrdenPrestador();

                if ($request['tipoOrden'] == 'servicio') {
                    $nuevaGestion['orden_procedimiento_id'] = $request['id'];

                    $ordenProcedimiento = OrdenProcedimiento::find($request['id']);
                    $ordenProcedimiento['estado_id_gestion_prestador'] = $estado;
                    $ordenProcedimiento->save();
                } else {
                    $nuevaGestion['orden_codigo_propio_id'] = $request['id'];

                    $ordenCodigoPropio = OrdenCodigoPropio::find($request['id']);
                    $ordenCodigoPropio['estado_id_gestion_prestador'] = $estado;
                    $ordenCodigoPropio->save();
                }

                $nuevaGestion['estado_gestion_id'] = $request['estado'];
                $nuevaGestion['observacion'] = $request['observaciones'];
                $nuevaGestion['funcionario_responsable'] = $request['funcionario_responsable'];
                $nuevaGestion['funcionario_gestiona'] = auth()->user()->id;
                $nuevaGestion->save();
                break;
            case 58:
                $nuevaGestion = new GestionOrdenPrestador();
                if ($request['tipoOrden'] == 'servicio') {
                    $nuevaGestion['orden_procedimiento_id'] = $request['id'];

                    $ordenProcedimiento = OrdenProcedimiento::find($request['id']);
                    $ordenProcedimiento['estado_id_gestion_prestador'] = $estado;
                    $ordenProcedimiento->save();
                } else {
                    $nuevaGestion['orden_codigo_propio_id'] = $request['id'];

                    $ordenCodigoPropio = OrdenCodigoPropio::find($request['id']);
                    $ordenCodigoPropio['estado_id_gestion_prestador'] = $estado;
                    $ordenCodigoPropio->save();
                }
                $nuevaGestion['estado_gestion_id'] = $request['estado'];
                $nuevaGestion['fecha_resultado'] = $request['fecha_resultado'];
                $nuevaGestion['observacion'] = $request['observaciones'];
                $nuevaGestion['funcionario_responsable'] = $request['funcionario_responsable'];
                $nuevaGestion['fecha_sugerida'] = $request['fecha_sugerida'];
                $nuevaGestion['fecha_solicita_afiliado'] = $request['fecha_solicitada_afiliado'];
                $nuevaGestion['cirujano'] = $request['cirujano'];
                $nuevaGestion['especialidad'] = $request['especialidad'];
                $nuevaGestion['fecha_preanestesia'] = $request['fecha_preanestesia'];
                $nuevaGestion['fecha_cirugia'] = $request['fecha_cirugia'];
                $nuevaGestion['fecha_ejecucion'] = $request['fecha_ejecucion'];
                $nuevaGestion->save();
        }
    }

    public function cancelar($request)
    {
        // Buscar si la consulta está activa
        $consultaActiva = Consulta::where('id', $request["consulta"])
            ->where('afiliado_id', $request["afiliado"])
            ->whereIn('estado_id', [13, 14, 59])
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
            if ($consultaActiva->cita->whatsapp === true) {
                $this->keironService->cambiarEstadoApiKeiron(1271, 15502, $request["consulta"]);
            }

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

    public function comandoRegistroCobros($consultaId)
    {
        $consulta = Consulta::with('afiliado')->find($consultaId);
        $afiliado = $consulta->afiliado;
        $this->registrarServicio($afiliado, $consultaId);
    }

    public function registrarServicio($afiliado, $consultaId)
    {
        $afiliado->loadMissing([
            'tipoDocumento',
            'departamento_afiliacion',
            'municipio_afiliacion',
            'tipo_afiliacion',
            'ips'
        ]);
        $consulta = Consulta::find($consultaId);
        $repId = $consulta->rep_id;
        $cupId = $consulta->cup_id;

        $sedesCapitadas = [77565, 77570, 77351, 77577, 77576, 77575, 16024, 1876, 77558, 14024, 77579, 77580, 13742, 77592, 13740, 13743, 13741, 13739, 1609, 2959, 14124, 77590, 77563, 77566, 77567, 77568, 77571, 77569, 77572, 77573, 77578, 77574, 77564, 497, 77352, 1667, 1392, 77350, 1193, 14489, 51350, 3497, 51547];
        $ipsCodigo = $afiliado->ips->codigo ?? null;
        $ipsId = $afiliado->ips->id ?? null;
        $contrato = in_array($ipsId, $sedesCapitadas) ? ($this->cupService->verificarManual($cupId, [4, 5], [$repId]) ? '12076-031-2024' : '194') : '194';

        $afiliadoSUMI = Afiliado::with('tipo_afiliacion')->find($afiliado->id);
        $tipoAfiliacionNombre = optional($afiliadoSUMI->tipo_afiliacion)->nombre;

        $categoria = $tipoAfiliacionNombre === 'SUBSIDIADO' ? '12'
            : match (true) {
                default => '12',
            };
        $ipsPorCodigo = Rep::where('codigo', $ipsCodigo)->first();
        $prestador = $ipsPorCodigo->prestador;

        $empresa = match (true) {
            $afiliado->entidad_id === 1 => 'RES003',
            $afiliado->entidad_id === 2 && $tipoAfiliacionNombre === 'SUBSIDIADO' => 'EPSS37',
            $afiliado->entidad_id === 2 && $tipoAfiliacionNombre === 'CONTRIBUTIVO' => 'EPS0037',
            default => null,
        };
        $diagnostico = Cie10Afiliado::where('consulta_id', $consultaId)
            ->where('esprimario', true)
            ->with('cie10')
            ->first();
        if ($diagnostico == null) {
            $codigoDiagnostico = 'Z000'; // CIE10 por defecto
        } else {
            $codigoDiagnostico = $diagnostico->cie10->codigo_cie10;
        }
        $cup = Cup::find($cupId);
        $valorCup = Contrato::select('cup_tarifas.valor')
            ->join('tarifas', 'tarifas.contrato_id', 'contratos.id')
            ->join('cup_tarifas', 'cup_tarifas.tarifa_id', 'tarifas.id')
            ->where('tarifas.rep_id', $repId)
            ->where('cup_tarifas.cup_id', $cup->id)
            ->where('entidad_id', 1)->first();
        if ($valorCup != null) {
            $valorCr = floatval($valorCup->valor);
        } else {
            $valorCr = 0;
        }
        /// PROCESO PARA REGISTRAR LAS FACTURAS A FACTURACION ELECTRONICA
        $datosAdmision = [
            "sede_atencion_id" => $repId,
            "afiliado_id" => $consulta->afiliado_id,
            "consulta_id" => $consulta->id,
            "codigo_empresa" => $empresa,
            "codigo_clasificacion" => $categoria,
            "fecha_ingreso" => Carbon::parse($consulta->fecha_hora_inicio)->format('Y-m-d'),
            "hora_ingreso" => Carbon::parse($consulta->fecha_hora_inicio)->format('H:i:s'),
            "medico_atiende_id" => $consulta->medico_ordena_id,
            "contrato" => $contrato,
            "codigo_diagnostico" => $codigoDiagnostico,
            "cups" => [
                [
                    "codigo" => $cup->codigo,
                    "descripcion" => $cup->nombre,
                    "cantidad" => 1,
                    "valor" => $valorCr,
                ]
            ],
        ];
        return $this->facturacionElectronicaService->guardarConsultasAfacturar($datosAdmision);
    }
}
