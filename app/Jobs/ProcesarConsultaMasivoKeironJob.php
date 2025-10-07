<?php

namespace App\Jobs;

use App\Http\Modules\LogsKeiron\models\LogsKeiron;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcesarConsultaMasivoKeironJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $consulta;
    public $tries = 1;
    /**
     * Create a new job instance.
     */
    public function __construct($consulta)
    {
        $this->consulta = $consulta;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::channel('keiron')->info('a job');
        $consulta = $this->consulta;

        $horaCita = Carbon::parse($consulta->fecha_hora_inicio, 'America/Bogota')
            ->setTimezone('UTC')
            ->toISOString();

        $entidad = match (true) {
            $consulta->paciente_entidad_id == 1 => 'MAGISTERIO',
            $consulta->paciente_entidad_id == 3 => 'FERROCARRIL',
            default => $consulta->paciente_entidad_nombre,
        };

        $payload = [
            "email1" => $consulta->paciente_correo1 ?? 'Sin correo principal',
            "medical_center_str" => $consulta->sede_nombre,
            "cellphone1" => $consulta->paciente_celular1,
            "appointment_datetime" => $horaCita,
            "patient_name" => $consulta->paciente_nombre_completo,
            "specialty_str" => $consulta->especialidad_nombre,
            "professional_str" => $consulta->medico_nombre_completo,
            "external_id" => $consulta->id,
            "patient_id" => $consulta->paciente_numero_documento,
            "location" => $consulta->sede_direccion,
            "flow" => config('services.keiron.flow_keiron'),
            "appointment_type_str" => $consulta->cita_nombre,
            "entidad" => $entidad,
            "status" => strval(config('services.keiron.status_board')),
        ];

        $errores = null;
        $dealId = null;
        $status = null;

        try {
            $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . config('services.keiron.token_envio_keiron'),
            ];

            $response = Http::withHeaders($headers)
                ->timeout(120)
                ->post('https://api.keiron.cl/crm/deal/custom', $payload);

            $deal = $response->json();

            if ($response->successful()) {
                $status = strval(config('services.keiron.status_board'));
                $dealId = $deal['data']['id'] ?? null;
            } else {
                $status = 'error_http_' . $response->status();
                $errores = $response->body();
            }

            LogsKeiron::updateOrCreate(
                ['consulta_id' => $consulta->id],
                [
                    'dealId' => $dealId,
                    'status' => $status,
                    'email' => $consulta->paciente_correo1 ?? 'Sin correo principal',
                    'nombre_afiliado' => $consulta->paciente_nombre_completo,
                    'transition_id' => config('services.keiron.transition_send'),
                    'fecha_consulta' => $consulta->fecha_hora_inicio,
                    'errores' => $errores,
                    'log_payload' => json_encode($payload, JSON_PRETTY_PRINT),
                ]
            );

        } catch (\Exception $e) {
            LogsKeiron::updateOrCreate(
                ['consulta_id' => $consulta->id],
                [
                    'dealId' => null,
                    'status' => 'error_exception',
                    'email' => $consulta->paciente_correo1 ?? 'Sin correo principal',
                    'nombre_afiliado' => $consulta->paciente_nombre_completo,
                    'transition_id' => config('services.keiron.transition_send'),
                    'log_payload' => json_encode($payload, JSON_PRETTY_PRINT),
                    'fecha_consulta' => $consulta->fecha_hora_inicio,
                    'errores' => $e->getMessage()
                ]
            );

            throw new Exception('Error en el envío de la cita a Keiron: ' . $e->getMessage(), 422);
        }

        Log::channel('keiron')->info('Finalizado job Keiron para consulta ID: ' . $consulta->id);
    }

    public function failed(\Throwable $exception)
    {
        dispatch(new ProcesarConsultaMasivoKeironJob($this->consulta))
            ->delay(now()->addSeconds(30))
            ->onQueue('envio-masivo-keiron');
    }
}
