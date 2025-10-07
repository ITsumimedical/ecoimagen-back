<?php

namespace App\Listeners;

use App\Events\OrdenDispensada;
use App\Http\Modules\Ordenamiento\Services\OrdenamientoService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotificarOrdenDispensada implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(protected OrdenamientoService $ordenamientoService) {}

    /**
     * Handle the event.
     */
    public function handle(OrdenDispensada $event): void
    {
        $this->ordenamientoService->notificarOrdenDispensada($event->movimiento);
    }
}
