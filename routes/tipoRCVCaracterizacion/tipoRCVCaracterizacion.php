<?php

use App\Http\Modules\TipoRCVCaracterizacion\Controllers\TipoRCVCaracterizacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-rcv-caracterizacion', 'throttle:60,1')->group(function () {
    Route::controller(TipoRCVCaracterizacionController::class)->group(function () {
        Route::get('listarTodas', 'listarTodas');
    });
});