<?php

use App\Http\Modules\DemandaInducida\Controllers\DemandaInducidaController;
use Illuminate\Support\Facades\Route;

Route::prefix('demanda-inducidas')->middleware('throttle:60,1')->group(function () {
    Route::controller(DemandaInducidaController::class)->group(function () {
        Route::post('crear', 'crear');
        Route::post('eliminarDemandaInducida', 'eliminarDemandaInducida');
        Route::post('listar', 'listar');
        Route::post('reporteDemandaInducida', 'reporteDemandaInducida');
        Route::get('verificarDatos', 'verificarDatos');
        Route::post('asignarCita', 'asignarCitaDemandaInducida');
    });
});
