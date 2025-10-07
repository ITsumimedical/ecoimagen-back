<?php

use App\Http\Modules\Recomendaciones\Controllers\RecomendacionesController;
use Illuminate\Support\Facades\Route;

Route::prefix('recomendaciones')->group(function () {
    Route::controller(RecomendacionesController::class)->group(function (){
        Route::post('listar', 'listar');
        Route::post('listarCondicionado', 'listarCondicionado');
        Route::post('crear','crear');
        Route::put('actualizar/{id}', 'actualizar');
        Route::post('cambiarEstado/{id}', 'cambiarEstado');
    });
});
