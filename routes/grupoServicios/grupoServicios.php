<?php

use App\Http\Modules\GrupoServicios\Controllers\grupoServiciosController;
use Illuminate\Support\Facades\Route;

Route::prefix('grupoServicios', 'throttle:60,1')->group(function () {
    Route::controller(grupoServiciosController::class)->group(function() {
        Route::post('crear', 'crearServicio');
        Route::get('listar', 'listar');
        Route::put('actualizar/{id}', 'actualizar');
    });
});
