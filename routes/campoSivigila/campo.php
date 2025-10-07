<?php

use App\Http\Modules\Epidemiologia\Controllers\CampoController;
use Illuminate\Support\Facades\Route;

Route::prefix('campos-sivigila')->group( function () {
    Route::controller(CampoController::class)->group(function (){
        Route::post('listar-campos','listarCampos');
        Route::post('crear-campo', 'crearCampos');
        Route::post('actualizar-campo/{id}', 'actualizarCampos');
        Route::post('cambiar-estado-campo/{id}', 'cambiarEstadoCampo');
        Route::post('listar-campos-evento','listarCamposPorEvento');
        Route::post('agregar-condicion/{id}', 'agregarCondicion');
    });
});
