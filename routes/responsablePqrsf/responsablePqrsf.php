<?php

use App\Http\Modules\ResponsablePqrsf\Controllers\ResponsablePqrsfController;
use Illuminate\Support\Facades\Route;

Route::prefix('responsable-pqrsf', 'throttle:60,1')->group(function () {
    Route::controller(ResponsablePqrsfController::class)->group(function() {
        Route::post('listar', 'listar');
        Route::post('listarTodos', 'listarTodos');
        Route::post('crear','crear');
        Route::put('actualizar/{id}','actualizar');
        Route::post('cambiarEstado/{id}','CambiarEstado');
    });
});
