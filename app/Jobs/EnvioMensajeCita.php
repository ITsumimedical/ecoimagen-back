<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use App\Http\Services\SmsService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Modules\Afiliados\Models\Afiliado;

class EnvioMensajeCita implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    private $smsService;
    /**
     * Create a new job instance.
     */
    public function __construct(array $data, SmsService $smsService)
    {
        $this->data = $data;
        $this->smsService = $smsService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $horaAtencion = substr($this->data['agenda']['fecha_inicio'], 11, 10);
        $fechaAtension = Carbon::parse($this->data['agenda']['fecha_inicio'])->translatedFormat('d F Y');
        $afiliado = $this->data["paciente"]["id"];
        $celularAfiliado = Afiliado::where('id', $afiliado)->first();

        $nombreAfiliado = $celularAfiliado->primer_nombre . ' ' . $celularAfiliado->segundo_nombre ?? '' . $celularAfiliado->primer_apellido . ' ' . $celularAfiliado->segundo_apellido ?? '';

        $celular = $celularAfiliado->celular1;
        $msg = 'Se asigno la cita de tipo' . $this->data["cita"]["nombre"] . ' ' . 'al Afiliado' . ' ' . $nombreAfiliado. ' ' . 'identificado con' . ' ' .
            $this->data['paciente']['tipo_documento']['nombre'] . ' ' . 'N°' . ' ' . $this->data['paciente']['numero_documento'] . ' ' .
            'el día' . ' ' . $fechaAtension . ' ' . 'a las' . ' ' . $horaAtencion . ' ' . 'en la Sede' . ' ' . $this->data['sede']['nombre'] . ',' . ' ' . 'en el' . ' ' .
            $this->data['agenda']['consultorio']['nombre'] . ' ' . 'con el Médico' . ' ' . $this->data['medico']['nombre'];
        $this->smsService->envioSms($celular, $msg);
    }
}
