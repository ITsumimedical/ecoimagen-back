<?php

use App\Http\Modules\Historia\Odontograma\Controllers\OdontogramaController;
use Illuminate\Support\Facades\Route;

Route::prefix('odontograma', 'throttle:60,1')->group(function () {
    Route::controller(OdontogramaController::class)->group(function () {
        Route::post('guardar-parametrizacion', 'guardarParametrizacion');
        Route::get('listar', 'listar');
        Route::get('listar-parametros', 'listarParametros');
        Route::get('listar-odontograma/{id}','listarOdontograma');
        Route::post('guardar/{id}','guardarOdontograma');
        Route::post('cambiar-estado-parametros/{id}','cambiarEstadoParametros');
        Route::post('guardarImagen', 'guardarImagen');
        Route::put('actualizar-parametrizacion/{id}', 'actualizarParametrizacion');
		Route::get('calculo-cop-ceo/{afiliado_id}', 'calculoCopCeo');
		Route::get('calculo-informe-202/{afiliado_id}', 'calcularInforme202');
    });
});
