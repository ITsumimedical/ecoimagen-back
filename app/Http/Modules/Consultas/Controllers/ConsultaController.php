<?php

namespace App\Http\Modules\Consultas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Modules\Citas\Models\Cita;
use Illuminate\Support\Facades\Storage;
use App\Http\Modules\Agendas\Models\Agenda;
use App\Http\Modules\Historia\Models\Historia;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Consultas\Services\ConsultaService;
use App\Http\Modules\CampoHistorias\Models\CampoHistoria;
use App\Http\Modules\Consultas\Repositories\ConsultaRepository;
use App\Http\Modules\CategoriaHistorias\Models\CategoriaHistoria;
use App\Http\Modules\Consultas\Requests\ConsultarFirmaTelemedicinaRequest;
use App\Http\Modules\Consultas\Requests\ConsultaTriageRequest;
use App\Http\Modules\Consultas\Requests\CrearFirmaConsentimientosRequest;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Requests\ActualizarServicioSolicitaRequest;
use App\Jobs\EnvioMensajeCita;
use App\Http\Services\SmsService;
use Error;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ConsultaController extends Controller
{

    public function __construct(protected ConsultaRepository $consultaRepository, protected ConsultaService $consultaService, protected SmsService $smsService)
    {
    }

    /**
     * lista las consultas
     * @param Request $request
     * @return Response
     * @author Calvarez
     */
    public function citasIndividales(Request $request)
    {
        try {
            $consulta = $this->consultaRepository->citasIndividales(auth()->id(), $request->estados);
            return response()->json($consulta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar usuarios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function citasGrupales(Request $request)
    {
        try {
            $consulta = $this->consultaRepository->citasGrupales(auth()->id(), $request->id);
            return response()->json($consulta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar las consultas grupales',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function citasAgrupadas()
    {
        try {
            $consulta = $this->consultaRepository->citasAgrupadas(auth()->id());
            return response()->json($consulta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar las consultas grupales',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Asignar uns cita al afiliado
     * @param Request $request
     * @return Response
     * @author Calvarez
     */
    public function crear(Request $request)
    {

        try {
            $asignacionCitaAfiliado = $this->consultaService->guardar($request->all());
            if ($request['cita']['sms'] === true) {
                EnvioMensajeCita::dispatch($request->all(), $this->smsService)->onQueue('envio-mensaje-cita');
            }
            return response()->json($asignacionCitaAfiliado, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al asignar cita al afiliado!.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function generarHistoria($cita)
    {
        try {
            $historia = Cita::with("categoriasHistoria.campoHistoria")->find($cita);
            return response()->json([
                'res' => true,
                'data' => $historia
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar la historia',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function guardarHistoria(Request $request, Consulta $consulta)
    {
        $errores = [];
        $valores = [];
        $categorias = CategoriaHistoria::select([
            'categoria_historias.*',
            'chc.orden',
            'chc.requerido'
        ])
            ->with(['campos'])
            ->join('categoria_historia_cita as chc', 'chc.categoria_historia_id', 'categoria_historias.id')
            ->join('citas as c', 'c.id', 'chc.cita_id')
            ->join('agendas as a', 'a.cita_id', 'c.id')
            ->where('a.id', $consulta->agenda_id)
            ->orderBy('chc.orden', 'asc')
            ->get();
        foreach ($categorias as $categoria) {
            switch (intval($categoria['tipo_categoria_historia_id'])) {
                case 1:
                    foreach ($categoria['campos'] as $campo) {
                        if (boolval($campo['requerido']) && (!isset($request[$campo['id']]) || !$request[$campo['id']])) {
                            $errores[] = ['mensaje' => 'El campo ' . $campo['nombre'] . ' en ' . $categoria['nombre'] . ' esta vacio y es requerido', 'campo' => $campo['id']];
                        }
                        if ($request[$campo['id']]) {
                            $valores[] = ['consulta_id' => $consulta->id, 'campo_historia_id' => $campo['id'], 'resultado' => $request[$campo['id']]];
                        }
                    }
                    break;
                case 2:
                    foreach ($categoria['campos'] as $campo) {
                        if (boolval($categoria['requerido'])) {
                            if (!isset($request[$campo['id']]) || !$request[$campo['id']]) {
                                $errores[] = ['mensaje' => 'El campo ' . $campo['nombre'] . ' en ' . $categoria['nombre'] . ' esta vacio y es requerido.', 'campo' => $campo['id']];
                            }
                        }
                        if ($request[$campo['id']]) {
                            $valores[] = ['consulta_id' => $consulta->id, 'campo_historia_id' => $campo['id'], 'resultado' => $request[$campo['id']]];
                        }
                    }
                    break;
                case 3:
                    if (boolval($categoria['requerido'])) {
                        if (!isset($request[$categoria['id']]) || !$request[$categoria['id']]) {
                            $errores[] = ['mensaje' => 'La categoria ' . $categoria['nombre'] . ' requiere un valor.'];
                        }
                    }
                    if (isset($request[$categoria['id']]) || $request[$categoria['id']]) {
                        $campoTipo3 = CampoHistoria::where('categoria_historia_id', $categoria['id'])->where('nombre', 'ILIKE', $request[$categoria['id']])->first();
                        if ($campoTipo3) {
                            $valores[] = ['consulta_id' => $consulta->id, 'campo_historia_id' => $campoTipo3->id, 'resultado' => $campoTipo3->predeterminado];
                        }
                    }
                    break;
            }
        }
        if (count($errores) === 0) {
            Historia::insert($valores);
            $consulta->tipo_consulta_id = 8;
            $consulta->estado_id = 9;
            $consulta->save();
            return response()->json(['mensaje' => 'Registro guardado con exito'], 200);
        }
        return response()->json(['mensaje' => 'La Historia tiene inconsistencias', 'errores' => $errores], 400);
    }

    public function calcularEstadoAgenda($id)
    {
        $citasAsignadas = Consulta::where('agenda_id', $id)->whereIn('estado_id', [14, 13, 7, 9, 6])->count();
        $agenda = Agenda::find($id);
        if ($citasAsignadas >= intval($agenda->cita["cantidad_paciente"])) {
            $agenda->estado_id = 9;
        } else {
            $agenda->estado_id = 11;
        }
        $agenda->save();

        return $agenda;
    }

    public function consultasPaciente($afiliado)
    {
        try {
            $consultas = Consulta::with(['agenda', 'agenda.consultorio.rep'])->where('afiliado_id', $afiliado)->get();
            return response()->json($consultas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las consultas.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cancelarConsulta(Request $request)
    {
        try {
            $consulta = $this->consultaService->cancelar($request->all());
            return response()->json([
                'res' => true,
                'mensaje' => $consulta["mensaje"],
            ], $consulta["status"]);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al cancelar la consultas.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function reasignarConsulta(Request $request)
    {
        try {
            $consulta = $this->consultaService->reasignar($request->all());
            return response()->json([
                'res' => true,
                'mensaje' => $consulta["mensaje"],
            ], $consulta["status"]);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al cancelar la consultas.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function consulta(Request $request, int $consulta_id)
    {
        try {
            $consulta = $this->consultaRepository->consulta($consulta_id);
            return response()->json($consulta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * contadorConsultaPendientes
     * cuenta las consultas pendientes del afiliado
     *
     * @param  mixed $afiliado_id
     * @return void
     */
    public function contadorConsultaPendientes(int $afiliado_id)
    {
        try {
            $contador = $this->consultaRepository->contadorConsultaPendientes($afiliado_id);
            return response()->json($contador, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error al contar las consultas pendientes del afiliado!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Contador consultas individuales
     * @author calvarez
     */
    public function contadorConsultasIndividuales()
    {
        try {
            $contador = $this->consultaRepository->contadorConsultas();
            return response()->json($contador, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error al contar las consultas ocupacionales!',
                'err' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Contador consultas ocupacionales
     * @author calvarez
     */
    public function contadorConsultaOcupaciona()
    {
        try {
            $contador = $this->consultaRepository->contadorOcupacional();
            return response()->json($contador, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'erro' => $th->getMessage(),
                'error' => 'Error al contar las consultas ocupacionales!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function contadorConsultaNoProgramada()
    {
        try {
            $contador = $this->consultaRepository->contadorConsultaNoProgramada();
            return response()->json($contador, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error al contar las consultas pendientes del afiliado!'
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * lista las citas pendientes por atender ocupacionales
     * @param Request $request
     * @return Response
     * @author Calvarez
     */
    public function citasOcupacionales()
    {
        try {
            $consulta = $this->consultaRepository->citasOcupacionales(auth()->id());
            return response()->json($consulta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar usuarios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function generarNoProgramada(Request $request)
    {
        $mensaje = '';
        $status = 200;
        $afiliado = Afiliado::where('numero_documento', $request->documento)->first();

        if ($afiliado->estado_afiliacion_id !== 1) {
            throw new Error("El afiliado no se encuentra activo", 400);
        }

        if ($request->cita) {
            $cita = Cita::find($request->cita['id']); // Obtener la cita para validar el tipo_historia_id
            if ($cita) {
                switch ($cita->tipo_historia_id) {
                    case 5:
                        if ($afiliado->edad_cumplida < 12 || $afiliado->edad_cumplida > 17) {
                            throw new Error("La edad del afiliado debe estar entre 12 y 17 años para atender este tipo de historia. Edad actual" . ' ' . $afiliado->edad_cumplida, 400);
                        }
                        break;
                    case 6:
                        if ($afiliado->edad_cumplida < 0 || $afiliado->edad_cumplida > 5) {
                            throw new Error("La edad del afiliado debe estar entre 0 y 5 años para atender este tipo de historia. Edad actual" . ' ' . $afiliado->edad_cumplida, 400);
                        }
                        break;
                    case 7:
                        if ($afiliado->edad_cumplida < 6 || $afiliado->edad_cumplida > 11) {
                            throw new Error("La edad del afiliado debe estar entre 6 y 11 años para atender este tipo de historia. Edad actual" . ' ' . $afiliado->edad_cumplida, 400);
                        }
                        break;
                    case 8:
                        if ($afiliado->edad_cumplida < 18 || $afiliado->edad_cumplida > 28) {
                            throw new Error("La edad del afiliado debe estar entre 18 y 28 años para atender este tipo de historia. Edad actual" . ' ' . $afiliado->edad_cumplida, 400);
                        }
                        break;
                    case 9:
                        if ($afiliado->edad_cumplida < 29 || $afiliado->edad_cumplida > 59) {
                            throw new Error("La edad del afiliado debe estar entre 29 y 59 años para atender este tipo de historia. Edad actual" . ' ' . $afiliado->edad_cumplida, 400);
                        }
                        break;
                    case 10:
                        if ($afiliado->edad_cumplida < 60) {
                            throw new Error("La edad del afiliado debe ser mayor a 60 años para atender este tipo de historia. Edad actual" . ' ' . $afiliado->edad_cumplida, 400);
                        }
                        break;
                }
            }
        }
        if ($afiliado) {
            $ciclo_vida = '';
            if (intval($afiliado->edad_cumplida) <= 5) {
                $ciclo_vida = 'Primera Infancia (0-5 Años)';
            } else if (intval($afiliado->edad_cumplida) >= 6 && intval($afiliado->edad_cumplida) <= 11) {
                $ciclo_vida = 'Infancia (6-11 Años)';
            } else if (intval($afiliado->edad_cumplida) >= 12 && intval($afiliado->edad_cumplida) <= 17) {
                $ciclo_vida = 'Adolescencia (12 A 17 Años)';
            } else if (intval($afiliado->edad_cumplida) >= 18 && intval($afiliado->edad_cumplida) <= 28) {
                $ciclo_vida = 'Joven (18 A 28 Años)';
            } else if (intval($afiliado->edad_cumplida) >= 29 && intval($afiliado->edad_cumplida) <= 59) {
                $ciclo_vida = 'Adulto (29 A 59 Años)';
            } else {
                $ciclo_vida = 'Vejez (Mayor a 60 Años)';
            }
            $consulta = new Consulta();
            $consulta->finalidad = "Consulta No Programada";
            $consulta->fecha_hora_inicio = date('Y-m-d H:i:s');
            $consulta->afiliado_id = $afiliado->id;
            $consulta->cup_id = $request->cup;
            $consulta->estado_id = 7;
            $consulta->cita_no_programada = 1;
            $consulta->especialidad_id = $request->especialidad;
            $consulta->cita_id = $request->cita['id'];
            $consulta->tipo_consulta_id = 2;
            $consulta->medico_ordena_id = auth()->id();
            $consulta->rep_id = $request->sede;
            $consulta->ciclo_vida_atencion = $ciclo_vida;
            $consulta->hora_inicio_atendio_consulta = Carbon::now();
            $consulta->save();

            $infoConsulta = Consulta::with([
                'afiliado.clasificacion',
                'afiliado.caracterizacionAfiliado:id,afiliado_id,estratificacion_riesgo,grupo_riesgo,user_gestor_id,user_enfermeria_id',
                'afiliado.caracterizacionAfiliado.usuarioGestor.operador',
                'afiliado.caracterizacionAfiliado.usuarioEnfermeria.operador',
                'afiliado.ips:id,nombre',
                'afiliado.tipoDocumento:id,nombre,sigla',
                'afiliado.entidad:id,nombre',
                'afiliado.EstadoAfiliado:id,nombre',
                'afiliado.TipoAfiliado:id,nombre',
                'afiliado.tipo_afiliacion:id,nombre',
                'afiliado.municipio_atencion:id,nombre,codigo_dane',
                'afiliado.departamento_atencion:id,nombre,codigo_dane',
                'afiliado.municipio_afiliacion:id,nombre,codigo_dane',
                'afiliado.departamento_afiliacion:id,nombre,codigo_dane',
                'afiliado.medico.operador',
                'afiliado.medico2.operador',
                'afiliado.colegios:id,nombre', 'cita', 'cita.especialidad'])->where('id', $consulta->id)->first();
            // }

        } else {
            $infoConsulta = 'El numero de documento no se encuentra registrado';
            $status = 400;
        }
        return response()->json($infoConsulta, $status);
    }

    public function citasNoProgramadas()
    {
        $consultas = Consulta::with('cita.especialidad', 'afiliado.tipoDocumento')
            ->whereIn('estado_id', [13, 7, 14, 9, 8, 67])
            ->where('tipo_consulta_id', 2)
            ->whereDate('consultas.fecha_hora_inicio', Carbon::now())
            ->where('medico_ordena_id', Auth::id())
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($consultas);
    }

    public function firmaConsentimientos(ConsultarFirmaTelemedicinaRequest $request)
    {
        try {
            $consulta = $this->consultaService->guardarFirmaConsentimiento($request->validated());
            return response()->json($consulta, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al firmar el consentimientos.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function foto(Request $request)
    {

        $ordenProcedimiento = OrdenProcedimiento::find($request->id);
        // $foto = base64_decode(explode(',', $request->foto)[1]);

        /** Se genera una ruta unica para el archivo */
        // $ruta_foto = 'firmaConsentimientos/fotos/' . uniqid() . '.png';
        // $ruta_foto_guardar = '/storage/app/public/' . $ruta_foto;
        // Storage::disk('public')->put($ruta_foto, $foto);
        // $ruta_firma_paciente = public_path('firmaConsentimientos/firmas/' . uniqid() . '.png');

        $ordenProcedimiento->update([
            // 'foto' => $ruta_foto_guardar,
            'firma_consentimiento' => $request->firma,
            'aceptacion_consentimiento' => $request->aceptacion_consentimiento,
            'firmante' => $request->firmante,
            'numero_documento_representante' => $request->numero_documento_representante,
            'declaracion_a' => $request->declaracion_a,
            'declaracion_b' => $request->declaracion_b,
            'declaracion_c' => $request->declaracion_c,
            'nombre_profesional' => $request->nombre_profesional,
            'nombre_representante' => $request->nombre_representante
        ]);
    }

    public function aplicacionesPendientes(Request $request)
    {
        try {
            $aplicaciones = $this->consultaRepository->aplicacionesPendientes($request);
            return response()->json($aplicaciones, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las ordenes',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function confirmar(Request $request)
    {
        try {
            $consulta = $this->consultaService->confirmar($request);
            return response()->json($consulta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al Confirmar la consulta.',
            ], $th->getCode() ?: Response::HTTP_BAD_REQUEST);
        }
    }

    public function consultasPendientesPaciente(Request $request, $afiliado)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $page = $request->query('page', 1);

            $consultas = Consulta::with(['agenda.consultorio.rep', 'agenda.medicos.operador', 'cita.especialidad', 'user.operador', 'estado'])
                ->where('afiliado_id', $afiliado)
                ->whereIn('estado_id', [10, 13, 14, 59, 67])
                ->whereNull('finalidad')
                ->where('cita_no_programada', '!=', true)
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json($consultas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las consultas.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function consultasAtendidasPaciente($afiliado)
    {
        try {
            $citasAtendidadas = $this->consultaService->consultasAtendidasPaciente($afiliado);
            return response()->json($citasAtendidadas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las consultas.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Consulta un cita paciente en especifico
     * @param Request $request
     * @param consulta_id $consulta_id
     * @return Response
     * @author kobatime
     */
    public function consultarConsulta($consulta_id)
    {
        try {
            $consulta = $this->consultaService->consultarCita($consulta_id);
            return response()->json($consulta, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar la cita.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Consultar telemedicina
     * @param Request $request
     * @param consulta_id $consulta_id
     * @return Response
     * @author kobatime
     */
    public function consultarConsentimientoTeleconsulta(ConsultarFirmaTelemedicinaRequest $request)
    {
        try {
            $consulta = $this->consultaService->consultarTelemedicina($request->validated());
            return response()->json($consulta, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar la cita.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarServicioSolicita(ActualizarServicioSolicitaRequest $request, Consulta $consulta)
    {
        try {
            $consulta->update($request->validated());
            return response()->json($consulta, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar la consulta.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function verificarEstadoConsulta($consultaId)
    {
        try {
            $consulta = $this->consultaService->verificarEstadoConsulta($consultaId);
            return response()->json($consulta, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al verificar el estado de la consulta.',
            ]);
        }
    }

    public function asignarCitaAutogestion(Request $request)
    {
        try {
            $asignacionCitaAfiliado = $this->consultaService->asignarCitaAutogestion($request->all());
            return response()->json($asignacionCitaAfiliado, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al asignar cita al afiliado!',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function historicoCitasAfiliado()
    {
        try {
            $citasAfiliado = $this->consultaService->historicoCitasAfiliado();
            return response()->json($citasAfiliado, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al obtener las citas del afiliado.',
            ]);
        }
    }

    /**
     * Lista las consultas sin finalizar desde el día anterior hacia atrás.
     * Si se proporciona un número de documento en la solicitud, se aplica un filtro
     * para obtener únicamente las consultas del afiliado con ese documento.
     * Este método maneja la solicitud del cliente, pasando los datos
     * al repositorio para obtener las consultas y devolviendo una respuesta JSON.
     *
     * @param Request $request La solicitud HTTP que contiene los posibles filtros, incluyendo el número de documento del afiliado.
     * @return JsonResponse Respuesta JSON con las consultas sin finalizar o un error en caso de fallo.
     * @throws \Throwable Captura de cualquier excepción que pueda ocurrir durante el proceso.
     * @author Thomas Restrepo
     */
    public function consultasSinFinalizar(Request $request): JsonResponse
    {
        try {
            $consulta = $this->consultaRepository->consultasSinFinalizar($request);
            return response()->json($consulta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar usuarios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function detallesOrdenConsulta($consultaActivaId)
    {
        try {
            $detalles = $this->consultaRepository->detallesOrdenConsulta($consultaActivaId);
            return response()->json($detalles, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al obtener los detalles de la consulta.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Lista las consultas NO PROGRAMADAS sin finalizar desde el día anterior hacia atrás.
     * Si se proporciona un número de documento en la solicitud, se aplica un filtro
     * para obtener únicamente las consultas del afiliado con ese documento.
     * Este método maneja la solicitud del cliente, pasando los datos
     * al repositorio para obtener las consultas y devolviendo una respuesta JSON.
     *
     * @param Request $request La solicitud HTTP que contiene los posibles filtros, incluyendo el número de documento del afiliado.
     * @return JsonResponse Respuesta JSON con las consultas sin finalizar o un error en caso de fallo.
     * @throws \Throwable Captura de cualquier excepción que pueda ocurrir durante el proceso.
     * @author Thomas Restrepo
     */
    public function noProgramadasSinFinalizar(Request $request): JsonResponse
    {
        try {
            $consulta = $this->consultaRepository->noProgramadasSinFinalizar($request);
            return response()->json($consulta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar usuarios',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function consultarCitas(Request $request)
    {
        try {
            $consultas = $this->consultaRepository->consultarCitas($request);
            return response()->json($consultas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function confirmarAdmision(Request $request)
    {
        try {
            $consulta = $this->consultaService->confirmarAdmision($request);
            return response()->json($consulta, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al cancelar la consultas.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function guardarFirma(Request $request)
    {
        try {
            $consulta = $this->consultaService->guardarFirma($request);
            return response()->json($consulta, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al cancelar la consultas.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function crearCitaDemanda(Request $request)
    {
        try {
            $asignacionCitaAfiliado = $this->consultaService->asignarSinRestricciones($request->all());
            return response()->json($asignacionCitaAfiliado);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al asignar cita al afiliado!.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function consultarCompleto(Request $request)
    {
        try {
            $registroCompleto = $this->consultaRepository->consultarCompleto($request);
            return response()->json($registroCompleto);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar los registros de la consulta!.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Crea una consulta de urgencias para realizar el triage
     * @param Request $request con el id de la admision de urgencias.
     * @return JsonResponse Respuesta JSON con la consulta.
     * @author JDSS
     */
    public function generarConsultaTriage(ConsultaTriageRequest $request)
    {
        try {
            $consulta = $this->consultaService->generarConsultaTriage($request->validated());
            return response()->json($consulta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Se obtiene una consulta de el triage
     * @param Request $request con el id de la consulta.
     * @return JsonResponse Respuesta JSON con la consulta.
     * @author JDSS
     */
    public function obtenerConsultaTriage(Request $request)
    {
        try {
            $consulta = $this->consultaRepository->obtenerConsultaTriage($request->consulta_id);
            return response()->json($consulta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Verifica si el medico atiende la consulta, sino lo actualiza
     * @param int $consultaId
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function verificarMedicoAtiende(int $consultaId): JsonResponse
    {
        try {
            $this->consultaRepository->verificarMedicoAtiende($consultaId);
            return response()->json([
                'res' => true,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function ConsultasPorEspecialidad(Request $request)
    {
        try {
            $consulta = $this->consultaRepository->ConsultasPorEspecialidad($request);
            return response()->json($consulta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function firmarConsentimientoAnestesia(Request $request)
    {
        try{
            $consulta = $this->consultaService->firmarConsentimientoAnestesia($request->all());
            return response()->json($consulta, Response::HTTP_OK);
        }catch(\Throwable $th){
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
