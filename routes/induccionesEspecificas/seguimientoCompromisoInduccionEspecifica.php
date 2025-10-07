<?php

use App\Http\Modules\InduccionesEspecificas\SeguimientoCompromisoInduccionesEspecificas\Controllers\SeguimientoCompromisoInduccionEspecificaController;
use Illuminate\Support\Facades\Route;

Route::prefix('seguimiento-compromisos-inducciones-especificas', 'throttle:60,1')->group(function () {
    Route::controller(SeguimientoCompromisoInduccionEspecificaController::class)->group(function () {
        Route::get('{id}', 'listar');//->middleware('permission:seguimientoCompromisoInduccionEspecifica.listar');
        Route::post('crear', 'crear');//->middleware('permission:seguimientoCompromisoInduccionEspecifica.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:seguimientoCompromisoInduccionEspecifica.actualizar');
    });
});
