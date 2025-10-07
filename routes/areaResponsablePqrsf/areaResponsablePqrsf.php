<?php

use App\Http\Modules\AreaResponsablePqrsf\Controllers\AreaResponsablePqrsfController;
use Illuminate\Support\Facades\Route;

Route::prefix('area-responsable-pqrsf', 'throttle:60,1')->group(function () {
    Route::controller(AreaResponsablePqrsfController::class)->group(function () {
        Route::post('listar', 'listar');
        Route::post('listarTodo', 'listarTodo');
        Route::post('crear', 'crear');
        Route::put('actualizar/{id}', 'actualizar');
        Route::post('cambiarEstado/{id}', 'CambiarEstado');
        Route::get('listarAreasUsuario', 'listarAreasUsuario');
    });
});
