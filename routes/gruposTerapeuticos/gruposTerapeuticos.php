<?php

use App\Http\Modules\Codesumis\gruposTerapeuticos\Controllers\gruposTerapeuticosController;
use Illuminate\Support\Facades\Route;

Route::prefix('grupos-terapeuticos', 'throttle:60,1')->group(function () {
    Route::controller(gruposTerapeuticosController::class)->group(function () {
        Route::get('listar', 'listar');
        Route::post('crear', 'crear');
        Route::put('actualizar/{id}', 'actualizar');
    });
});
