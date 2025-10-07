<?php

use App\Http\Modules\GestionPqrsf\TipoSolicitudes\Controllers\TipoSolicitudpqrsfController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipos-solicitudes-pqrsf')->group( function () {
    Route::controller(TipoSolicitudpqrsfController::class)->group(function (){
        Route::get('listar','listar');
        Route::get('listarTodos','listarTodos');
        Route::post('crear','crear');
        Route::put('/{id}','actualizar');
        Route::post('cambiarEstado/{id}','cambiarEstado');
    });
});
