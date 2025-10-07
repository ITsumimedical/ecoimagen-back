<?php

use App\Http\Modules\InduccionesEspecificas\CompromisoInduccionesEspecificas\Controllers\CompromisoInduccionEspecificaController;
use Illuminate\Support\Facades\Route;

Route::prefix('compromisos-inducciones-especificas', 'throttle:60,1')->group(function () {
    Route::controller(CompromisoInduccionEspecificaController::class)->group(function () {
        Route::get('{id}', 'listar');//->middleware('permission:compromisoInduccionEspecifica.listar');
        Route::post('crear', 'crear');//->middleware('permission:compromisoInduccionEspecifica.crear');
    });
});
