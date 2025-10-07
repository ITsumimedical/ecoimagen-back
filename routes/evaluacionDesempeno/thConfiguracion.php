<?php

use App\Http\Modules\EvaluacionDesempeño\Th_Configuracion\Controllers\ThConfiguracionController;
use Illuminate\Support\Facades\Route;


Route::prefix('th-configuracion')->group(function (){
    Route::controller(ThConfiguracionController::class)->group(function (){
        Route::get('fechaEvaluacion', 'fechaEvaluacion');//->middleware('permission:thTipoPlantilla.listar');
        Route::post('crear', 'crear');//->middleware('permission:thTipoPlantilla.crear');
    });
});
