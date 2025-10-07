<?php

use App\Http\Modules\Incapacidades\Controllers\IncapacidadController;
use Illuminate\Support\Facades\Route;

Route::prefix('incapacidades', 'throttle:60,1')->group(function () {
    Route::controller(IncapacidadController::class)->group(function () {
        Route::post('registrar', 'registrarIncapacidad');
        Route::post('anularIncapacidad', 'anularIncapacidad');
        Route::get('historico-incapacidad', 'historicoIncapacidad');
        Route::put('editarFecha/{id}', 'editarFechaIncapacidad');
        Route::post('ordenesIncapacidadAfiliado', 'ordenesIncapacidadAfiliado');
    });
});
