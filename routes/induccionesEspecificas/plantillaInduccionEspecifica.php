<?php

use App\Http\Modules\InduccionesEspecificas\PlantillasInduccionesEspecificas\Controllers\PlantillaInduccionEspecificaController;
use Illuminate\Support\Facades\Route;

Route::prefix('plantillas-inducciones-especificas', 'throttle:60,1')->group(function () {
    Route::controller(PlantillaInduccionEspecificaController::class)->group(function () {
        Route::get('listar', 'listar');//->middleware('permission:plantillasInduccionEspecifica.listar');
        Route::post('crear', 'crear');//->middleware('permission:plantillasInduccionEspecifica.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:plantillasInduccionEspecifica.actualizar');
    });
});
