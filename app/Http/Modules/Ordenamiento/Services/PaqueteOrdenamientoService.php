<?php

namespace App\Http\Modules\Ordenamiento\Services;

use App\Http\Modules\Ordenamiento\Models\PaqueteOrdenamiento;
use Throwable;

class PaqueteOrdenamientoService
{

    public function asignarCups(int $paqueteId, array $cups): void
    {
        $paquete = PaqueteOrdenamiento::findOrFail($paqueteId);
        $paquete->cups()->sync($cups);
    }

    public function asignarCodesumis(int $paqueteId, array $codesumis): void
    {
        $paquete = PaqueteOrdenamiento::findOrFail($paqueteId);
        $paquete->codesumis()->sync($codesumis);
    }

    public function obtenerCups(int $paqueteId): array
    {
        $paquete = PaqueteOrdenamiento::with('cups')->findOrFail($paqueteId);
        return $paquete->cups->toArray();
    }

    public function obtenerCodesumis(int $paqueteId): array
    {
        $paquete = PaqueteOrdenamiento::with('codesumis')->findOrFail($paqueteId);
        return $paquete->codesumis->toArray();
    }
}
