<?php

use App\Http\Modules\Grupos\Controllers\GrupoController;
use Illuminate\Support\Facades\Route;

Route::prefix('grupos', 'throttle:60,1')->group(function () {
    Route::controller(GrupoController::class)->group(function () {
        Route::get('listar', 'listar');
        Route::post('crear','crear');
        Route::put('actualizar/{id}','actualizar');

    });
});
