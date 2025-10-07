<?php

use App\Http\Modules\CondicionesRiesgoCaracterizacion\Controllers\CondicionesRiesgoCaracterizacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('condiciones-riesgo-caracterizacion', 'throttle:60,1')->group(function () {
    Route::controller(CondicionesRiesgoCaracterizacionController::class)->group(function () {
        Route::get('listarTodas', 'listarTodas');
    });
});