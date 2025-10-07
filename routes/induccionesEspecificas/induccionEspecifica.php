<?php

use App\Http\Modules\InduccionesEspecificas\InduccionesEspecificas\Controllers\InduccionEspecificaController;
use Illuminate\Support\Facades\Route;

Route::prefix('inducciones-especificas', 'throttle:60,1')->group(function () {
    Route::controller(InduccionEspecificaController::class)->group(function () {
        Route::get('contadores-inducciones', 'contadoresInducciones');
        Route::put('/cerrar/{induccion}', 'cerrar');//->middleware('permission:induccionEspecifica.cerrar');
        Route::get('listar', 'listar');//->middleware('permission:induccionEspecifica.listar');
        Route::post('crear', 'crear');//->middleware('permission:induccionEspecifica.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:induccionEspecifica.actualizar');
    });
});
