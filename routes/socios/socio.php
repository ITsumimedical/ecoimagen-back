<?php

use App\Http\Modules\Socios\Controllers\SocioController;
use Illuminate\Support\Facades\Route;

Route::prefix('socio', 'throttle:60,1')->group(function () {
    Route::controller(SocioController::class)->group(function () {
        Route::post('listar', 'listar')      ;
        Route::post('crear', 'crear')       ;
        Route::post('inactivar', 'inactivar')       ;

    });
});
