<?php

use App\Http\Modules\PreguntasTest\Controllers\preguntasTipoTestController;
use Illuminate\Support\Facades\Route;

Route::prefix('preguntasTipoTest', 'throttle:60,1')->group(function () {
    Route::controller(preguntasTipoTestController::class)->group(function () {
        Route::post('crearPreguntas', 'crearPreguntas');
        Route::get('listar', 'listar');
        Route::post('listarPorNombreTest', 'listarPorNombreTest');
        Route::put('actualizar/{id}', 'actualizar');
    });
});
