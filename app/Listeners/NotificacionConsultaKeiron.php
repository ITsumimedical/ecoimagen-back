<?php

namespace App\Listeners;

use App\Events\EnviarKeiron;
use App\Http\Modules\LogsKeiron\Services\KeironService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotificacionConsultaKeiron
{
    /**
     * Create the event listener.
     */
    public function __construct(protected KeironService $keironService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EnviarKeiron $event): void
    {
        $data = $event->request;
        $consulta = $event->consulta;
        $this->keironService->consultasApikeiron($data, $consulta);
    }
}
