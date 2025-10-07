<?php

use App\Http\Modules\PersonalExpuesto\Controllers\PersonalExpuestoController;
use Illuminate\Support\Facades\Route;

Route::prefix('personal-expuesto', 'throttle:60,1')->group(function () {
    Route::controller(PersonalExpuestoController::class)->group(function () {
        Route::post('listar', 'listar')      ;
        Route::post('crear', 'crear')       ;
        Route::post('inactivar', 'inactivar')       ;

    });
});
