<?php

use App\Http\Modules\Chat\Controllers\MensajeController;
use Illuminate\Support\Facades\Route;

Route::prefix('mensaje','throttle:60,1')->group(function () {
    Route::controller(MensajeController::class)->group(function () {
        Route::get('listar/{user_id}','listar');
        Route::post('crear','crear');
        Route::post('crearAdjunto','crearAdjunto');
        Route::put('/{id}','actualizar');
        Route::put('/marcar-visto/{id}', 'marcarVisto');
        Route::get('exportarChat/{id}' , 'exportarChat');
    });
});
