<?php

namespace App\Http\Modules\LogsKeiron\Services;

use App\Http\Modules\Afiliados\Repositories\AfiliadoRepository;
use App\Http\Modules\Agendas\Models\Agenda;
use App\Http\Modules\Auditorias\Models\Auditoria;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Consultas\Models\ConsultaOrdenProcedimientos;
use App\Http\Modules\Consultas\Repositories\ConsultaRepository;
use App\Http\Modules\LogsKeiron\models\LogsKeiron;
use App\Http\Modules\Ordenamiento\Models\OrdenCodigoPropio;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Jobs\ProcesarConsultaMasivoKeironJob;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class KeironService
{
    public function __construct(private ConsultaRepository $consultaRepository, private readonly AfiliadoRepository $afiliadoRepository)
    {
    }

    public function consultasApikeiron($datosCita, $consulta)
    {

        $urlProyecto = config('services.app_name.nombre_app');

        if ($urlProyecto !== "https://horus-health.com") {
            return false;
        }

        if ($datosCita['cita']['whatsapp'] === false) {
            return false;
        }

        $horaCita = Carbon::parse($consulta->fecha_hora_inicio, 'America/Bogota')
            ->setTimezone('UTC')
            ->toISOString();

        $nombreAfiliado = $datosCita['paciente']['nombre_completo'];
        $correo = $datosCita['paciente']['correo1'];
        $celular = $datosCita['paciente']['celular1'];
        $sedeNombre = $datosCita['sede']['nombre'];
        $especialidad = $datosCita['especialidad']['nombre'];
        $medico = $datosCita['medico']['nombre'];
        $tipoCita = $datosCita['cita']['nombre'];
        $direccion = $datosCita['sede']['direccion'];
        $entidadId = $datosCita['paciente']['entidad']['id'];
        $entidadNombre = $datosCita['paciente']['entidad']['nombre'];

        if ((empty($celular) || !ctype_digit($celular) || strlen($celular) != 10) && !empty($datosCita['paciente']['numero_documento_cotizante'])) {
            $cotizanteEncontrado = $this->afiliadoRepository->consultarAfiliadoDocumento(strval($datosCita['paciente']['numero_documento_cotizante']));
            $celular = $cotizanteEncontrado->celular1;

        }

        $entidad = match (true) {
            $entidadId == 1 => 'MAGISTERIO',
            $entidadId == 3 => 'FERROCARRIL',
            default => $entidadNombre,
        };

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . config('services.keiron.token_envio_keiron'),
        ];

        $payload = [
            "email1" => $correo,
            "medical_center_str" => $sedeNombre,
            "cellphone1" => $celular,
            "appointment_datetime" => $horaCita,
            "patient_name" => $nombreAfiliado,
            "specialty_str" => $especialidad,
            "professional_str" => $medico,
            "external_id" => $consulta->id,
            "patient_id" => $datosCita['paciente']['numero_documento'],
            "location" => $direccion,
            "flow" => config('services.keiron.flow_keiron'),
            "appointment_type_str" => $tipoCita,
            "entidad" => $entidad,
            "status" => (string) config('services.keiron.status_board'),
        ];

        try {
            $response = Http::withHeaders($headers)
                ->timeout(120)
                ->post('https://api.keiron.cl/crm/deal/custom', $payload);

            $deal = $response->json();

            if ($response->successful()) {
                $status = $deal['data']['status'] ?? null;
                $dealId = $deal['data']['id'];
            } else {
                $status = 'error_http_' . $response->status();
                $errores = $response->body();
            }

            LogsKeiron::create(
                [
                    'consulta_id' => $consulta->id,
                    'dealId' => $dealId ?? null,
                    'status' => $status,
                    'email' => $datosCita['paciente']['correo1'],
                    'nombre_afiliado' => $nombreAfiliado,
                    'transition_id' => config('services.keiron.transition_send'),
                    'fecha_consulta' => $consulta->fecha_hora_inicio,
                    'errores' => $errores ?? null,
                    'log_payload' => json_encode($payload),
                ]
            );

            return true;

        } catch (\Exception $e) {
            LogsKeiron::updateOrCreate(
                ['consulta_id' => $consulta->id],
                [
                    'dealId' => null,
                    'status' => 'error_exception',
                    'email' => $datosCita['paciente']['correo1'],
                    'nombre_afiliado' => $nombreAfiliado,
                    'transition_id' => config('services.keiron.transition_send'),
                    'fecha_consulta' => $consulta->fecha_hora_inicio,
                    'errores' => $e->getMessage(),
                    'log_payload' => json_encode($payload),
                ]
            );

            throw new Exception('error en el envio de la cita a keiron ' . $e->getMessage(), 422);
        }

    }

    public function cambiarEstadoApiKeiron(int $status, int $transition, int $consultaId): array
    {
        $keiron = LogsKeiron::where('consulta_id', $consultaId)->first();

        if (!$keiron) {
            return [
                'success' => false,
                'message' => 'No se encontró el registro de LogsKeiron',
            ];
        }

        $dealId = $keiron->dealId;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . config('services.keiron.token_envio_keiron'),
        ])->timeout(120)->post("https://api.keiron.cl/crm/integration-generic/deals/{$dealId}/transitions", [
                    "transitionId" => $transition
                ]);

        if ($response->successful()) {
            Log::channel('keiron')->info("consulta confirmada {$response}, 'success");
            $keiron->update([
                'status' => $status,
                'transition_id' => $transition,
            ]);

            return [
                'success' => true,
                'data' => $response->json(),
            ];
        }

        Log::channel('keiron')->info("consulta confirmada {$response}, procesada");


        return [
            'success' => false,
            'status_code' => $response->status(),
            'error' => $response->json(),
        ];
    }

    public function masivoConsultas(array $request)
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        $contadorGlobal = 0;

        $masivo = DB::table('consultas')
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
            ->whereNull('lk.consulta_id')
            ->whereDate('agendas.fecha_inicio', '>=', '2025-09-04')
            ->where('consultas.estado_id', 13)
            ->where('ct.whatsapp', true)
            ->where('use.activo', true)
            ->get();

        $chunked = array_chunk($masivo->toArray(), 50);

        $contadorGlobal = 0;
        $consultasEnKeiron = 0;

        foreach ($chunked as $index => $grupo) {
            foreach ($grupo as $consulta) {

                if ((empty($consulta->paciente_celular1) || !ctype_digit($consulta->paciente_celular1) || strlen($consulta->paciente_celular1) != 10) && !empty($consulta->numero_documento_cotizante)) {
                    $cotizanteEncontrado = $this->afiliadoRepository->consultarAfiliadoDocumento(strval($consulta->numero_documento_cotizante));
                    $consulta->paciente_celular1 = $cotizanteEncontrado->celular1 ?? '000';
                }

                $headers = [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . config('services.keiron.token_envio_keiron'),
                ];

                $payload = [
                    "filter" => ["external_id" => $consulta->id],
                    "options" => ["limit" => 1]
                ];

                $response = Http::withHeaders($headers)
                    ->timeout(120)
                    ->post(
                        'https://api.keiron.cl/crm/integration-generic/flows/' . config('services.keiron.flow_keiron') . '/bulk-search',
                        $payload
                    )->json();

                if (!isset($response['data']['hits'])) {
                    Log::channel('keiron')->error("Respuesta inválida de keiron para consulta {$consulta->id}", $response);
                    continue;
                }

                $hits = intval($response['data']['hits']);

                if ($hits >= 1) {
                    $consultasEnKeiron++;

                    $logs = LogsKeiron::where('consulta_id', $consulta->id)->first();

                    if (!$logs) {
                        LogsKeiron::updateOrCreate(
                            ['consulta_id' => $consulta->id],
                            [
                                'dealId' => $response['data']['deals'][0]['id'] ?? null,
                                'status' => $response['data']['deals'][0]['statusId'],
                                'email' => $consulta->paciente_correo1 ?? 'Sin correo principal',
                                'nombre_afiliado' => $consulta->paciente_nombre_completo,
                                'transition_id' => config('services.keiron.transition_send'),
                                'fecha_consulta' => $consulta->fecha_hora_inicio,
                                'errores' => $errores ?? null,
                            ]
                        );
                    }
                    Log::channel('keiron')->info("Consulta {$consulta->id} ya existe en keiron");
                } else {
                    $contadorGlobal++;

                    ProcesarConsultaMasivoKeironJob::dispatch($consulta)->onQueue('envio-masivo-keiron');

                    Log::channel('keiron')->info("Consulta {$consulta->id} enviada a la cola");
                }
                if ($contadorGlobal > 0 && $contadorGlobal % 50 === 0) {

                    Log::channel('keiron')->info("Pausa de 10 segundos: se han procesado {$contadorGlobal} consultas // en Keiron Encontradas {$consultasEnKeiron} ");
                    sleep(10);
                }
            }

            Log::channel('keiron')->info("Van {$contadorGlobal} consultas procesadas hasta el momento (chunk {$index})");
        }

        return [
            'success' => true,
            'message' => 'Las consultas se están procesando en segundo plano.',
            'contador_global' => $contadorGlobal
        ];
    }

    public function cambiarEstadoHorus(int $id, array $datos)
    {
        $consulta = Consulta::find($id);
        $datos['motivo_cancelacion'] = null;

        if (in_array($consulta->estado_id, [8, 9, 67])) {
            throw new \Exception("La cita ya ha sido gestionada previamente.");
        }

        if (!LogsKeiron::where('consulta_id', $id)->exists() || !$consulta) {
            throw new \Exception("Cita no encontrada.");
        }

        if (!in_array((int) $datos['estado_id'], [14, 30])) {
            throw new \Exception('Valor de "estado_id" no válido.');
        }

        LogsKeiron::where('consulta_id', $id)->update([
            'status' => $datos['estado_id'] == 14 ? 1270 : 1271,
        ]);

        if ((int) $datos['estado_id'] === 30) {
            $datos['motivo_cancelacion'] = "Afiliado realiza cancelación por vía Whatsapp";
            Agenda::where('id', $consulta->agenda_id)->update([
                'estado_id' => 11,
            ]);
            $consulta->update([
                'estado_id' => $datos['estado_id'],
                'motivo_cancelacion' => $datos['motivo_cancelacion'],
            ]);
            // Verificar si la consulta tiene una orden asociada
            $ordenConsulta = ConsultaOrdenProcedimientos::where('consulta_id', $consulta->id)->first();

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
            $consulta->delete();
        } else {
            $consulta->update([
                'estado_id' => 67,
                'motivo_cancelacion' => $datos['motivo_cancelacion'],
            ]);
        }

        return [
            'success' => true,
            'message' => 'Estado de la cita actualizado correctamente.',
        ];
    }

    public function masivoCanceladasPendientes()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        $contadorGlobal = 0;

        $masivoCancelacionesPendientes = DB::table('consultas')
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
            ->whereDate('agendas.fecha_inicio', '>=', '2025-09-04')
            ->where('consultas.estado_id', 30)
            ->where('ct.whatsapp', true)
            ->where('use.activo', true)
            ->get();


        $chunked = array_chunk($masivoCancelacionesPendientes->toArray(), 50);

        $contadorGlobal = 0;

        foreach ($chunked as $index => $grupo) {
            foreach ($grupo as $consulta) {
                $headers = [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . config('services.keiron.token_envio_keiron'),
                ];

                $payload = [
                    "filter" => ["external_id" => $consulta->id],
                    "options" => ["limit" => 1]
                ];

                $response = Http::withHeaders($headers)
                    ->timeout(120)
                    ->post(
                        'https://api.keiron.cl/crm/integration-generic/flows/' . config('services.keiron.flow_keiron') . '/bulk-search',
                        $payload
                    )->json();


                if (isset($response['data']['deals'][0]['id'])) {
                    $this->cambiarEstadoApiKeiron(config('services.keiron.status_cancelado'), config('services.keiron.transition_cancelado'), $consulta->id);
                } else {
                    continue;
                }

            }

            Log::channel('keiron')->info("Van {$contadorGlobal} consultas procesadas hasta el momento (chunk {$index})");
        }

        return [
            'success' => true,
            'message' => 'Envio de canceladas Faltante Ejecutado',
        ];
    }

}
