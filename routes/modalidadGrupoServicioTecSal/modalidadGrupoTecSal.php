<?php

use App\Http\Modules\ModalidadGrupoTecSal\Controllers\modalidadGrupoTecSalController;
use Illuminate\Support\Facades\Route;

Route::prefix('modalidadgrupoTec', 'throttle:60,1')->group(function () {
    Route::controller(modalidadGrupoTecSalController::class)->group(function() {
        Route::get('listar', 'listar');
        Route::post('crear', 'crearModalidad');
        Route::put('actualizar/{id}', 'actualizar');

    });
});
