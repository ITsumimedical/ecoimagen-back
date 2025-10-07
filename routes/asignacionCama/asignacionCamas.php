<?php

use App\Http\Modules\AsignacionCamas\Controllers\AsignacionCamaController;
use App\Http\Modules\AsistenciaEducativa\Controllers\asistenciaEducativaController;
use Illuminate\Support\Facades\Route;

Route::prefix('asignacion-cama', 'throttle:60,1')->group(function () {
    Route::controller(AsignacionCamaController::class)->group(function () {
        Route::get('listar', 'listar');
        Route::post('crear', 'crear');
    });
});
