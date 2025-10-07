<?php

use App\Http\Modules\GestionTurnos\Controllers\GestionTurnoController;
use Illuminate\Support\Facades\Route;

Route::prefix('gestion-turno', 'throttle:60,1')->group(function () {
    Route::controller(GestionTurnoController::class)->group(function() {
        Route::get('', 'listar');//->middleware(['permission:gestionTurno.listar']);
        Route::post('','guardar');//->middleware(['permission:gestionTurno.guardar']);
        Route::put('/{gestion}','actualizar');//->middleware(['permission:gestionTurno.actualizar']);
    });
});
