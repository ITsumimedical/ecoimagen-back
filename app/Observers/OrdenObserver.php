<?php

namespace App\Observers;

use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Ordenamiento\Services\OrdenInteroperabilidadService;
use Illuminate\Support\Facades\Storage;

class OrdenObserver
{
    public function __construct(
        private OrdenInteroperabilidadService $ordenInteroperabilidadService
    )
    {}
    /**
     * Handle the Orden "created" event.
     */
    public function created(Orden $orden): void
    {
        try {
            $response = $this->ordenInteroperabilidadService->enviar($orden);
            Storage::append('primera_prueba.txt', $response);
        } catch (\Throwable $th) {
            Storage::append('primera_prueba.txt', $th->getMessage());
        }
    }
}
