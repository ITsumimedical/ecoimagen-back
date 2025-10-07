<?php

use App\Http\Modules\rqc\Controller\RqcController;
use Illuminate\Support\Facades\Route;

Route::prefix('rqc', 'throttle:60,1')->group(function () {
    Route::controller(RqcController::class)->group(function() {
        Route::post('crear', 'crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatos');
    });
});
