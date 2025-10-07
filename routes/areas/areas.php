<?php

use App\Http\Modules\areasPrincipales\Controller\areasController;
use Illuminate\Support\Facades\Route;

Route::prefix('areas', 'throttle:60,1')->group(function () {
    Route::controller(areasController::class)->group(function () {
        Route::post('crear', 'crear');
        Route::post('listar', 'listar');
        Route::get('listarTodos', 'listarTodos');
        Route::put('actualizar/{id}', 'actualizar');
        Route::post('cambiarEstado/{id}', 'cambiarEstado');
        Route::get('buscarPorNombre/{nombre}', 'buscarPorNombre');
    });
});
