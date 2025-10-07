<?php

use App\Http\Modules\RutaPromocionCaracterizacion\Controllers\RutaPromocionCaracterizacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('ruta-promocion-caracterizacion', 'throttle:60,1')->group(function () {
    Route::controller(RutaPromocionCaracterizacionController::class)->group(function () {
        Route::get('listarTodas', 'listarTodas');
    });
});