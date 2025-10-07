<?php

use App\Http\Modules\TipoAlerta\Controllers\TipoAlertaController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-alerta')->group(function () {
    Route::controller(TipoAlertaController::class)->group(function (){
        Route::post('listar','listar');
        Route::post('crear','crear');
        Route::put('actualizar/{id}','actualizar');
        Route::put('cambiarEstado/{tipo_id}','cambiarEstado');

    });
});
