<?php

use App\Http\Modules\Eventos\AccionesMejora\Controllers\AccionMejoraController;
use Illuminate\Support\Facades\Route;

Route::prefix('accion-mejora-eventos')->group(function () {
    Route::controller(AccionMejoraController::class)->group(function () {
        Route::post('crear', 'crear');
        Route::get('{id}', 'listar');
        Route::post('/{accionMejoraEvento}', 'actualizar');
        Route::post('/{accionMejoraEvento}/eliminar', 'actualizarDeletedAt');
    });
});
