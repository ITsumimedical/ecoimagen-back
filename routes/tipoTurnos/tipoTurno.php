<?php

use App\Http\Modules\TipoTurnos\Controllers\TipoTurnoController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-turno', 'throttle:60,1')->group(function () {
    Route::controller(TipoTurnoController::class)->group(function() {
        Route::get('', 'listar')                ;//->middleware(['permission:tipoTurno.listar']);
        Route::post('','guardar')               ;//->middleware(['permission:tipoTurno.guardar']);
        Route::put('/{tipo_turno}','actualizar');//->middleware(['permission:tipoTurno.actualizar']);
    });
});
