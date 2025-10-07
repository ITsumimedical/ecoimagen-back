<?php

use App\Http\Modules\Telesalud\Controllers\TelesaludController;
use Illuminate\Support\Facades\Route;

Route::prefix('telesalud', 'throttle:60,1')->group(function () {
    Route::controller(TelesaludController::class)->group(function () {
        Route::post('crearTelesalud', 'crearTelesalud');
        Route::post('listarPendientes', 'listarPendientes');
        Route::get('listarDetallesTelesalud/{telesaludId}', 'listarDetallesTelesalud');
        Route::post('actualizarEspecialidad/{telesaludId}', 'actualizarEspecialidad');
        Route::post('listarSolucionadas', 'listarSolucionadas');
        Route::post('respuestaEspecialista/{telesaludId}', 'respuestaEspecialista');
        Route::post('listarJuntaPendientes', 'listarJuntaPendientes');
        Route::post('respuestaJunta/{telesaludId}', 'respuestaJunta');
        Route::post('listarJuntaSolucionadas', 'listarJuntaSolucionadas');
    });
});
