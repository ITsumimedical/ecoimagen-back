<?php

use App\Http\Modules\Juzgados\Controllers\JuzgadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('juzgado', 'throttle:60,1')->group(function () {
    Route::controller(JuzgadoController::class)->group(function() {
        Route::post('listar', 'listar');
        Route::post('buscar', 'buscar');
        Route::post('crear','crear');
        Route::put('/{id}','actualizar');
    });
});
