<?php

use App\Http\Modules\Interoperabilidad\Controllers\RegistroRecepcionOrdenesInteroperabilidadController;
use Illuminate\Support\Facades\Route;

Route::prefix('registro-recepcion-ordenes-interoperabilidad')->group(function () {
    Route::controller(RegistroRecepcionOrdenesInteroperabilidadController::class )->group(function () {
        Route::get('listar-seguimiento', 'listarSeguimiento'); 
    });
});