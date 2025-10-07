<?php

use App\Http\Modules\Contratos\Controllers\ContratoController;
use Illuminate\Support\Facades\Route;

Route::prefix('contrato', 'throttle:60,1')->group(function () {
    Route::controller(ContratoController::class)->group(function () {
            Route::post('/descargar-contratos','descargarContratos');
            Route::post('/descargar-plantilla-contratos', 'descargarPlantilla');//->middleware('permission:contrato.direccionamiento.actualizar');     
            Route::post('/carga-masiva', 'cargaMasiva');//->middleware('permission:contrato.guardar');   
            Route::get('', 'listar');//->middleware('permission:contrato.listar');allContrato
            Route::post('allContrato', 'listarTodosContratos');//->middleware('permission:contrato.listar');
            Route::get('/{contrato_id}', 'consultar');//->middleware('permission:contrato.listar');
            Route::post('/', 'guardar');//->middleware('permission:contrato.guardar');
            Route::get('consultarContrato/{contrato_id}', 'consultarContrato');//->middleware('permission:contrato.listar');
            Route::post('consultarCups/{contrato_id}', 'consultarCups');//->middleware('permission:contrato.listar');
            Route::post('/{contrato_id}', 'actualizar');//->middleware('permission:contrato.actualizar');
            Route::put('/cambiar-estado/{contrato}', 'cambiarEstado');//->middleware('permission:contrato.actualizar');
            Route::put('/contrato-cups/{contrato}','contratosCups');//->middleware('permission:contrato.guardar');
            Route::post('/importTarifa/{contrato_id}','subirCups');//->middleware('permission:contrato.actualizar');
            Route::post('eliminar/{contrato_id}', 'eliminarContrato');//->middleware('permission:contrato.guardar');
            Route::get('/listar-por-prestador/{prestador_id}', 'listarPorPrestador');//->middleware('permission:contrato.guardar');
        });
});

