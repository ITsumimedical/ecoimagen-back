<?php

use App\Http\Modules\MesaAyuda\MesaAyuda\Controllers\MesaAyudaController;
use Illuminate\Support\Facades\Route;

Route::prefix('mesa-ayuda', 'throttle:60,1')->group(function () {
    Route::controller(MesaAyudaController::class)->group(function () {
        Route::get('listar', 'listar');
        Route::get('listarMisSolicitudes', 'listarMisSolicitudes');
        Route::get('contadorMisPendientes', 'contadorMisPendientes');
        Route::get('contadorSolucionados', 'contadorSolucionados');
        Route::post('crear-caso', 'crearCaso');
        Route::put('/{id}', 'actualizar');
        Route::post('contador', 'contadorCasosPendientes');
        Route::post('listarSolicitudesHorus', 'listarSolicitudesHorus');
        Route::post('consultarAdjuntos', 'consultarAdjuntos');
        Route::post('reasignar/{id}', 'reasignarCaso');
        Route::post('solucionar/{mesaAyudaId}', 'solucionarSolicitud');
        Route::post('anular/{mesaAyudaId}', 'anularSolicitud');
        Route::post('asignar', 'asignar');
        Route::get('listarAsignados', 'listarAsignados');
        Route::post('devolver', 'devolver');
        Route::get('listarSolucionados', 'listarSolucionados');
        Route::post('reabrirCaso/{id}', 'reabrirCaso');
        Route::post('comentario/{id}', 'Comentario');
        Route::post('gestionando/{id}', 'gestionando');
        Route::post('calificar/{mesaAyudaId}', 'calificarGestion');
        Route::post('responderComentario/{id}', 'ResponderComentario');
        Route::post('fecha-meta/{id}', 'definirFechaMeta');
        Route::get('consultar-mesa-por-id/{id}', 'consultarMesaPorId');
        Route::post('consultarAdjuntosConUrl', 'consultarAdjuntosConUrl');
    });
});
