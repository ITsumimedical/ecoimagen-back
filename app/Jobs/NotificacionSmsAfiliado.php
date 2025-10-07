<?php

namespace App\Jobs;

use App\Http\Modules\Afiliados\Repositories\AfiliadoRepository;
use App\Http\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

class NotificacionSmsAfiliado implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     */
    public $tries = 1;

    public $timeout = 600;

    protected int $tipoDocumento;
    protected int $numeroDocumento;
    public function __construct(int $tipoDocumento, int $numeroDocumento)
    {
        $this->tipoDocumento = $tipoDocumento;
        $this->numeroDocumento = $numeroDocumento;
    }

    /**
     * Execute the job.
     */
    public function handle(AfiliadoRepository $afiliadoRepository, SmsService $smsService): bool
    {

        $afiliado = $afiliadoRepository->buscarAfiliadoTipoNumeroDocumento($this->tipoDocumento, $this->numeroDocumento);

        $codigo = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $afiliado->update([
            'notificacion_sms' => $codigo
        ]);

        $telefono = $afiliado->celular1;

        $mensajeSMS = "Tu código de verificación es: {$codigo},
                Úsalo para completar tu proceso. No lo compartas con nadie.";

        return $smsService->envioSms($telefono, $mensajeSMS);

    }
}
