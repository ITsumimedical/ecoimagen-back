<?php

use App\Http\Modules\Direccionamientos\Controllers\DireccionamientoController;
use Illuminate\Support\Facades\Route;

Route::prefix('direccionamiento', 'throttle:60,1')->group(function () {
    Route::controller(DireccionamientoController::class)->group(function () {
        Route::post('listar', 'listar');//->middleware('permission:contrato.direccionamiento.listar');
        Route::post('listarParametros', 'listarParametros');//->middleware('permission:contrato.direccionamiento.listar');
        Route::post('listar-parametros-pgp', 'listarParametrosPgp');//->middleware('permission:contrato.direccionamiento.listar');
        Route::post('', 'crear');//->middleware('permission:contrato.direccionamiento.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:contrato.direccionamiento.actualizar');
        Route::post('crearParametro', 'crearParametro');//->middleware('permission:contrato.direccionamiento.crear');
        Route::post('crear-parametro-pgp', 'crearParametroPgp');//->middleware('permission:contrato.direccionamiento.crear');
        Route::post('actualizarParametros', 'actualizarParametros');//->middleware('permission:contrato.direccionamiento.actualizar');
        Route::post('eliminaParametro', 'eliminaParametro');
        Route::post('elimina-parametro-pgp', 'eliminaParametroPGP');
        Route::get('eliminar-direccionamiento/{direccionamiento_id}', 'eliminarDireccionamiento');//->middleware('permission:contrato.direccionamiento.actualizar');
        Route::get('descargarPlantillaDireccionamiento', 'descargarPlantillaDireccionamiento');//->middleware('permission:contrato.direccionamiento.actualizar');
        Route::post('subirArchivo', 'subirArchivo');//->middleware('permission:contrato.direccionamiento.actualizar');
        Route::post('cambio-direccionamiento', 'cambioDireccionamiento');//->middleware('permission:contrato.direccionamiento.actualizar');
    });
});
