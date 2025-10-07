<?php

use App\Http\Modules\MesaAyuda\AreasMesaAyuda\Controllers\AreasMesaAyudaController;
use App\Http\Modules\MesaAyuda\MesaAyuda\Controllers\MesaAyudaController;
use Illuminate\Support\Facades\Route;

Route::prefix('area-mesa-ayuda', 'throttle:60,1')->group(function () {
    Route::controller(AreasMesaAyudaController::class)->group(function() {
        Route::post('listar' , 'listar');
        Route::post('crear','crear');
        Route::put('actualizar/{id}','actualizar');
        Route::post('cambiarEstado/{id}','cambiarEstado');
    });
});
