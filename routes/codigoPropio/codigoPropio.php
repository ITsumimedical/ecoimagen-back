<?php

use App\Http\Modules\CodigoPropios\Controllers\CodigoPropioController;
use Illuminate\Support\Facades\Route;


Route::prefix('codigo-propio')->group(function () {
    Route::controller(CodigoPropioController::class)->group(function () {
        Route::post('listar', 'listar');
        Route::get('/descargarPlantillaCodigoPropio', 'descargarPlantillaCodigoPropio');
        Route::post('/carga-masiva', 'cargaMasiva');
        Route::post('', 'crear');
        Route::get('/{id}', 'consultar');
        Route::put('/{codigo_propio_id}', 'actualizar');
        Route::put('/cambiar-estado/{id}', 'cambiarEstado');
        Route::get('/BuscarCodigoPropio/{nombre}', 'BuscarCodigoPropio');
    });
});
