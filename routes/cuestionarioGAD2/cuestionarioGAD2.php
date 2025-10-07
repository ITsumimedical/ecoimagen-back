<?php

use App\Http\Modules\CuestionarioGad2\Controller\cuestionarioGAD_2Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('cuestionarioGAD-2')->group( function () {
    Route::controller(cuestionarioGAD_2Controller::class)->group(function (){
        Route::post('crear','crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatos');
    });
});
