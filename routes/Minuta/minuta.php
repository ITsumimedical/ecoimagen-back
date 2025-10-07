<?php

use App\Http\Modules\Minuta\Controller\MinutaController;
use Illuminate\Support\Facades\Route;

Route::prefix('minuta', 'throttle:60,1')->group(function () {
    Route::controller(MinutaController::class)->group(function() {
        Route::post('crear','crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatos');
    });
});
