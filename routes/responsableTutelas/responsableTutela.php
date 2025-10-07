<?php

use App\Http\Modules\ResponsableTutela\Controllers\ResponsableTutelaController;
use Illuminate\Support\Facades\Route;

Route::prefix('responsable-tutela', 'throttle:60,1')->group(function () {
    Route::controller(ResponsableTutelaController::class)->group(function() {
        Route::post('listar', 'listar');
        Route::post('guardar','guardar');
        Route::put('/{responsable}','actualizar');
        Route::put('estado/{id}', 'actualizarEstado');
    });
});
