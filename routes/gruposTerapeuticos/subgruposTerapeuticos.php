<?php

use App\Http\Modules\Codesumis\subgruposTerapeuticos\Controllers\subgruposTerapeuticosController;
use Illuminate\Support\Facades\Route;

Route::prefix('subgrupos-terapeuticos', 'throttle:60,1')->group(function () {
    Route::controller(subgruposTerapeuticosController::class)->group(function () {
        Route::get('listar', 'listar');
        Route::post('crear', 'crear');
        Route::put('actualizar/{id}', 'actualizar');
    });
});
