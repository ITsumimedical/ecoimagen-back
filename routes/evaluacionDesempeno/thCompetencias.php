<?php

use App\Http\Modules\EvaluacionDesempeño\th_competencias\Controllers\ThCompetenciaController;
use Illuminate\Support\Facades\Route;


Route::prefix('th-competencias')->group(function (){
    Route::controller(ThCompetenciaController::class)->group(function (){
        Route::get('', 'listar');//->middleware('permission:thTipoPlantilla.listar');
        Route::post('crear', 'crear');//->middleware('permission:thTipoPlantilla.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:thTipoPlantilla.actualizar');
    });
});
