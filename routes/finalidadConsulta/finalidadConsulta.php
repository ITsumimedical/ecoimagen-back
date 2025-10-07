<?php

use App\Http\Modules\FinalidadConsulta\Controller\FinalidadConsultaController;
use Illuminate\Support\Facades\Route;

Route::prefix('finalidadConsulta')->group(function () {
    Route::controller(FinalidadConsultaController::class)->group(function (){
        Route::post('crear','crear');
        Route::get('listar', 'listar');
        Route::get('listarActivas', 'listarActivas');
        Route::put('actualizar/{id}', 'actualizar');
        Route::put('cambiarEstado/{id}', 'cambiarEstado');
    });
});
