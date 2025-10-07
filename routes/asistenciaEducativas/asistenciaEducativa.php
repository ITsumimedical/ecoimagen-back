<?php

use App\Http\Modules\AsistenciaEducativa\Controllers\asistenciaEducativaController;
use Illuminate\Support\Facades\Route;

Route::prefix('asistencia-educativas', 'throttle:60,1')->group(function () {
    Route::controller(asistenciaEducativaController::class)->group(function () {
        Route::get('listar', 'listar');
        Route::post('crear', 'crear');
        Route::post('reporteAsistencia', 'reporteAsistencia');
        Route::get('verificarDatos', 'verificarDatos');
    });
});
