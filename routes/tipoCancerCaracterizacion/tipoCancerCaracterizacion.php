<?php

use App\Http\Modules\TipoCancerCaracterizacion\Controllers\TipoCancerCaracterizacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-cancer-caracterizacion', 'throttle:60,1')->group(function () {
    Route::controller(TipoCancerCaracterizacionController::class)->group(function () {
        Route::get('listarTodas', 'listarTodas');
    });
});