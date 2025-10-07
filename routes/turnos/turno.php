<?php

use App\Http\Modules\Turnos\Controllers\TurnoController;
use Illuminate\Support\Facades\Route;

Route::prefix('turno', 'throttle:60,1')->group(function () {
    Route::controller(TurnoController::class)->group(function() {
        Route::get('', 'listar')                             ;//->middleware(['permission:turno.listar']);
        Route::post('','guardar')                            ;//->middleware(['permission:turno.guardar']);
        Route::put('/{turno}','actualizar')                  ;//->middleware(['permission:turno.actualizar']);
        Route::put('/cambiar-estado/{turno}','cambiarEstado');//->middleware(['permission:turno.actualizar']);
    });
});
