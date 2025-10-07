<?php

use App\Http\Modules\TipoViolencia\Controllers\TipoViolenciaController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-violencia', 'throttle:60,1')->group(function () {
    Route::controller(TipoViolenciaController::class)->group(function () {
        Route::get('listarTodas', 'listarTodas');
    });
});