<?php

use App\Http\Modules\Eventos\Analisis\Controllers\MotivoAnulacionEventoController;
use Illuminate\Support\Facades\Route;

Route::prefix('motivos-anulacion-eventos')->group( function () {
    Route::controller(MotivoAnulacionEventoController::class)->group(function (){
        Route::get('listar','listar');
    });
});
