<?php

use App\Http\Modules\InduccionesEspecificas\TemasInduccionesEspecificas\Controllers\TemaInduccionEspecificaController;
use Illuminate\Support\Facades\Route;

Route::prefix('temas-inducciones-especificas', 'throttle:60,1')->group(function () {
    Route::controller(TemaInduccionEspecificaController::class)->group(function () {
        Route::get('listar', 'listar');//->middleware('permission:temasInduccionEspecifica.listar');
        Route::get('{id}', 'listarTemaDePlantilla');//->middleware('permission:temasInduccionEspecifica.listar');
        Route::post('crear', 'crear');//->middleware('permission:temasInduccionEspecifica.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:temasInduccionEspecifica.actualizar');
    });
});
