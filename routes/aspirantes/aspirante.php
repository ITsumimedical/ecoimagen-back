<?php

use App\Http\Modules\Aspirantes\Controllers\AspiranteController;
use Illuminate\Support\Facades\Route;

Route::prefix('aspirantes', 'throttle:60,1')->group(function () {

    Route::controller(AspiranteController::class)->group(function () {
        Route::post('listar', 'listar');//->middleware('permission:aspirante.listar');
        Route::post('crear', 'crear');//->middleware('permission:aspirante.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:aspirante.actualizar');
    });
});
