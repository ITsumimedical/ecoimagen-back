<?php

use App\Http\Modules\Whooley\Controller\whooleyController;
use Illuminate\Support\Facades\Route;

Route::prefix('whooley')->group( function () {
    Route::controller(whooleyController::class)->group(function (){
        Route::post('crear','crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatos');
    });
});
