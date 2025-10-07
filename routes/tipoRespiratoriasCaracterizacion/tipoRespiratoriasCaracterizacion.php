<?php

use App\Http\Modules\TipoRespiratoriasCaracterizacion\Controllers\TipoRespiratoriasCaracterizacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-respiratorias-caracterizacion', 'throttle:60,1')->group(function () {
    Route::controller(TipoRespiratoriasCaracterizacionController::class)->group(function () {
        Route::get('listarTodas', 'listarTodas');
    });
});