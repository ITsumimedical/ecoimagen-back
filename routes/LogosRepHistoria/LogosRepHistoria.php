<?php

use App\Http\Modules\LogosRepsHistoria\Controller\LogosRepsHistoriaController;
use Illuminate\Support\Facades\Route;

Route::prefix('logo-rep-historia')->group(function () {
    Route::controller(LogosRepsHistoriaController::class)->group(function (){
        Route::post('crear-logo','crear');
        Route::get('logo-por-rep/{rep_id}','obtenerLogoPorRep');
        Route::post('crear-logo-prestador','subirLogoVariosReps');
    });
});
