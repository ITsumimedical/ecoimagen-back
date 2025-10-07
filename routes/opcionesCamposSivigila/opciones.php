<?php

use App\Http\Modules\Epidemiologia\Controllers\OpcionController;
use Illuminate\Support\Facades\Route;

Route::prefix('opciones-sivigila')->group( function () {
    Route::controller(OpcionController::class)->group(function (){
        Route::post('listar-opciones','listarOpciones');
        Route::post('crear-opcion', 'crearOpciones');
        Route::post('actualizar-opcion/{id}', 'actualizarOpciones');
        Route::post('cambiar-estado-opcion/{id}', 'cambiarEstadoOpcion');
        Route::post('listar-opciones-evento','listarOpcionesPorEvento');
    });
});
