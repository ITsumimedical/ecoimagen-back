<?php

use App\Http\Modules\Eventos\AccionesInseguras\Controllers\AccionInseguraController;
use Illuminate\Support\Facades\Route;

Route::prefix('accion-insegura-eventos')->group( function () {
    Route::controller(AccionInseguraController::class)->group(function (){
        Route::post('crear','crear');
        Route::get('{id}','listar');
        Route::put('{id}','actualizar');
        Route::post('/{accionInseguraEvento}/eliminar', 'actualizarDeletedAt');
    });
});
