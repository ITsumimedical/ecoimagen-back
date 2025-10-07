<?php

use App\Http\Modules\Codesumis\FormasFarmaceuticas\Controllers\formasFarmaceuticasController;
use Illuminate\Support\Facades\Route;

Route::prefix('formas-farmaceuticas', 'throttle:60,1')->group(function () {
    Route::controller(formasFarmaceuticasController::class)->group(function () {
        Route::get('listar', 'listar');
        Route::post('crear', 'crear');
        Route::put('actualizar/{id}', 'actualizar');
    });
});
