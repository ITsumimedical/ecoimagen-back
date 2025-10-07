<?php

use App\Http\Modules\NivelKaiser\Controller\nivelKaiserController;
use Illuminate\Support\Facades\Route;

Route::prefix('nivelKaiser', 'throttle:60,1')->group(function () {
    Route::controller(nivelKaiserController::class)->group(function () {
        Route::post('crear', 'crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatos');

    });
});
