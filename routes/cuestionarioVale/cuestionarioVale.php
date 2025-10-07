<?php

use App\Http\Modules\CuestionarioVale\Controller\CuestionarioValeController;
use Illuminate\Support\Facades\Route;

Route::prefix('cuestionario-vale')->group( function () {
    Route::controller(CuestionarioValeController::class)->group(function (){
        Route::post('crear','crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatos');
    });
});
