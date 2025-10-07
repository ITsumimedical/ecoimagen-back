<?php

use App\Http\Modules\MiniMental\Controller\miniMentalController;
use Illuminate\Support\Facades\Route;

Route::prefix('mini-mental', 'throttle:60,1')->group(function () {
    Route::controller(miniMentalController::class)->group(function() {
        Route::post('crear','crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatos');
        Route::get('guia', 'descargarGuia');
    });
});
