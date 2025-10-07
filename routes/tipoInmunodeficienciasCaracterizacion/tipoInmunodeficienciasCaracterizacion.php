<?php

use App\Http\Modules\TipoInmunodeficienciasCaracterizacion\Controllers\TipoInmunodeficienciasCaracterizacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-inmunodeficiencias-caracterizacion', 'throttle:60,1')->group(function () {
    Route::controller(TipoInmunodeficienciasCaracterizacionController::class)->group(function () {
        Route::get('listarTodas', 'listarTodas');
    });
});
