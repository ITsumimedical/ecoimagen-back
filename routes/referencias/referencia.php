<?php

use App\Http\Modules\Referencia\Controllers\ReferenciaController;
use Illuminate\Support\Facades\Route;

Route::prefix('referencias')->group(function()
{
    Route::controller(ReferenciaController::class)->group(function(){
        Route::get('listar', 'listarReferencias');//->middleware('permission:referencia.listar');
        Route::post('listarPedientesPrestador', 'listarPedientesPrestador');//->middleware('permission:referencia.listar');
        Route::post('crear', 'crearReferencia');//->middleware('permission:referencia.crear');
        Route::put('actualizar/{id}', 'actualizarReferencia');//->middleware('permission:referencia.actualizar');
        Route::put('finalizar/{id}', 'finalizarReferencia');//->middleware('permission:referencia.actualizar');
        Route::post('listarPedientes', 'listarPedientes');//->middleware('permission:referencia.actualizar');
        Route::post('listarProcesados', 'listarProcesados');//->middleware('permission:referencia.actualizar');
        Route::post('listarSeguimiento', 'listarSeguimiento');//->middleware('permission:referencia.actualizar');
        Route::post('listarProcesadoPrestador', 'listarProcesadoPrestador');//->middleware('permission:referencia.actualizar');
        Route::get('contadorReferenciasPendientes', 'contadorReferenciasPendientes');//->middleware('permission:referencia.listar');
        Route::get('contadorReferenciasSeguimiento', 'contadorReferenciasSeguimiento');//->middleware('permission:referencia.listar');
        Route::get('contadorReferenciasProcesado', 'contadorReferenciasProcesado');//->middleware('permission:referencia.listar');
        Route::get('contadorReferenciasProcesadoPrestador', 'contadorReferenciasProcesadoPrestador');//->middleware('permission:referencia.listar');
        Route::post('CrearConsulta', 'CrearConsulta');//->middleware('permission:referencia.listar');
        Route::post('reporte', 'reporte');//->middleware('permission:referencia.listar');
        Route::post('crearUrgencia','crearUrgencia');

    });
});
