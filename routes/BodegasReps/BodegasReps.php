<?php

use App\Http\Modules\BodegasReps\Controller\BodegasRepsController;
use Illuminate\Support\Facades\Route;

Route::prefix('bodegas-reps', 'throttle:60,1')->group(function () {
    Route::controller(BodegasRepsController::class)->group(function () {
        Route::post('crear', 'añadirRepsABodega');
        Route::get('listar/{bodegaId}', 'listarRepsPorBodega');
        Route::post('eliminar', 'eliminarRepsBodega');
    });
});
