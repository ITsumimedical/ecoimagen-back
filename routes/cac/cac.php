<?php

use App\Http\Modules\Cac\Controllers\CacController;

Route::prefix('cac')->group(function () {
    Route::controller(CacController::class)->group(function () {
        Route::post('crear-patologia', 'crearPatologia');
        Route::get('listar-patologias', 'listarPatologias');
        Route::patch('cambiar-estado/{patologia_id}', 'cambiarEstado');
        Route::post('asociar-especialidades-patologia', 'asociarEspecialidadesPatologia');
        Route::post('remover-especialidades-patologia', 'removerEspecialidadesPatologia');
        Route::get('listar-especialidades-patologia/{patologia_id}', 'listarEspecialidadesPatologia');
        Route::post('generar-archivo-cac','generarArchivoCac');
    });
});