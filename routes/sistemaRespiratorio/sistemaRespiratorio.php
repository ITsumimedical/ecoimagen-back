<?php

use App\Http\Modules\SistemaRespiratorio\Controllers\SistemaRespiratorioController;
use Illuminate\Support\Facades\Route;

Route::prefix('sistema-respiratorio')->group(function () {
    Route::controller(SistemaRespiratorioController::class)->group(function () {
        Route::post('crear', 'crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatos');
    });
});
