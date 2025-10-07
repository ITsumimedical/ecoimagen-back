<?php

use App\Http\Modules\Zarit\Controller\zaritController;
use Illuminate\Support\Facades\Route;

Route::prefix('zarit')->group( function () {
    Route::controller(zaritController::class)->group(function (){
        Route::post('crear','crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatos');
    });
});
