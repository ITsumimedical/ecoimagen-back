<?php

use App\Http\Modules\valoracionAntropometrica\Controller\ValoracionAntropometricaController;
use Illuminate\Support\Facades\Route;

Route::prefix('valoracionesAntropometricas')->group( function () {
    Route::controller(ValoracionAntropometricaController::class)->group(function (){
        Route::post('crear','crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatos');
    });
});
