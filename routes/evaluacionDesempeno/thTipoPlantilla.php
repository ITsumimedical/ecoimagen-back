<?php

use App\Http\Modules\EvaluacionDesempeño\th_tipo_plantillas\Controllers\ThTipoPlantillaController;
use Illuminate\Support\Facades\Route;


Route::prefix('th-tipo-plantillas')->group(function (){
    Route::controller(ThTipoPlantillaController::class)->group(function (){
        Route::get('', 'listar');//->middleware('permission:thTipoPlantilla.listar');
        Route::post('crear', 'crear');//->middleware('permission:thTipoPlantilla.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:thTipoPlantilla.actualizar');
    });
});
