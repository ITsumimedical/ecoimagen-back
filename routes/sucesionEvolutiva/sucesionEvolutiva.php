<?php

use App\Http\Modules\SucesionEvolutiva\Controller\SucesionEvolutivaController;
use Illuminate\Support\Facades\Route;

Route::prefix('sucesion','throttle:60,1')->group(function() {
    Route::controller(SucesionEvolutivaController::class)->group(function(){
        Route::post('crear','crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatosSucesionEvolutivaPorAfiliado');

    });
});
