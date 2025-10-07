<?php

use App\Http\Modules\Ordenamiento\SeguimientoInteroperabilidadController;
use Illuminate\Support\Facades\Route;

Route::prefix('ordenamiento')->group(function () {
    Route::controller(SeguimientoInteroperabilidadController::class)->group(function () {
        Route::get('/logs/interoperabilidad', 'listar');
        Route::post('/logs/asignar-cie10', 'asignarDiagnostico');
    });
});