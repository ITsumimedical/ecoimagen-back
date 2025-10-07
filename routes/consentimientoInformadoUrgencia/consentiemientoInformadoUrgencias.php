<?php

use App\Http\Modules\Urgencias\ConsentimientosInformados\Controllers\ConsentimientoInformadoUrgenciasController;
use Illuminate\Support\Facades\Route;


Route::prefix('consentimiento-informado-urgencias')->group(function (){
    Route::controller(ConsentimientoInformadoUrgenciasController::class)->group(function (){
        Route::post('crear', 'crear');
        Route::post('listarConsentimiento', 'listarConsentimiento');
        Route::put('/{id}','actualizar');
    });
});
