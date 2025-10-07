<?php

use App\Http\Modules\ProgramasFarmacia\Controllers\ProgramasBodegasController;
use Illuminate\Support\Facades\Route;

Route::prefix('programa-bodegas', 'throttle:60,1')->group(function () {
    Route::controller(ProgramasBodegasController::class)->group(function () {
        Route::post('crearPrograma', 'crearPrograma');
        Route::get('bodegas/{programaId}', 'listarBodegas');
        Route::delete('eliminar', 'eliminarBodegaPrograma');
    });
});

