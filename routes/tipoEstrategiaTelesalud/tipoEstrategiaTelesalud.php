<?php

use App\Http\Modules\Telesalud\Controllers\TipoEstrategiaTelesaludController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-estrategia-telesalud', 'throttle:60,1')->group(function () {
    Route::controller(TipoEstrategiaTelesaludController::class)->group(function () {
        Route::get('listarActivos', 'listarActivos');
    });
});
