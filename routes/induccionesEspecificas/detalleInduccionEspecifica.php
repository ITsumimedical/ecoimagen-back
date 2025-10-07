<?php

use App\Http\Modules\InduccionesEspecificas\DetalleInduccionesEspecificas\Controllers\DetalleInduccionEspecificaController;
use Illuminate\Support\Facades\Route;

Route::prefix('detalles-inducciones-especificas', 'throttle:60,1')->group(function () {
    Route::controller(DetalleInduccionEspecificaController::class)->group(function () {
        Route::get('{id}', 'listar');//->middleware('permission:induccionEspecifica.listar');
        Route::post('crear', 'crear');//->middleware('permission:induccionEspecifica.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:induccionEspecifica.actualizar');
    });
});
