<?php

use App\Http\Modules\OdontologiaProcedimientos\Controllers\odontologiaProcedimientosController;
use Illuminate\Support\Facades\Route;

Route::prefix('odontologiaProcedimientos', 'throttle:60,1')->group(function () {
    Route::controller(odontologiaProcedimientosController::class)->group(function () {
        Route::post('agregarCupConsulta', 'agregarCupConsulta');
        Route::get('listarProcedimientos/{consulta_id}', 'listarProcedimientos');
        Route::delete('eliminar/{id}', 'eliminar');
    });
});
