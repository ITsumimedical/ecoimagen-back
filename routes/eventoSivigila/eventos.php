<?php

use App\Http\Modules\Epidemiologia\Controllers\EventoController;
use Illuminate\Support\Facades\Route;

Route::prefix('eventos-sivigila')->group( function () {
    Route::controller(EventoController::class)->group(function (){
        Route::post('listar-eventos','listarEventos');
        Route::post('crear-evento', 'crearEventos');
        Route::post('actualizar-evento/{id}', 'actualizarEventos');
        Route::post('cambiar-estado-evento/{id}', 'cambiarEstadoEvento');
    });
});
