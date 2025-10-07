<?php

use App\Http\Modules\PatologiaRespiratoria\Controllers\PatologiaRespiratoriaController;
use Illuminate\Support\Facades\Route;

Route::prefix('patologia-respiratoria')->group( function () {
    Route::controller(PatologiaRespiratoriaController::class)->group( function () {
        Route::post('crear', 'crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatos');
    });
});
