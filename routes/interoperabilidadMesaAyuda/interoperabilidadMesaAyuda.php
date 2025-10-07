<?php

use App\Http\Modules\InteroperabilidadMesaAyuda\Controllers\InteroperabilidadMesaAyudaController;
use App\Http\Modules\MesaAyuda\MesaAyuda\Controllers\MesaAyudaController;
use Illuminate\Support\Facades\Route;

Route::prefix('interoperabilidad-mesa-ayuda', 'throttle:60,1')->group(function () {
    Route::controller(InteroperabilidadMesaAyudaController::class)->group(function () {
        Route::get('listar/{entidad}', [InteroperabilidadMesaAyudaController::class, 'listar']);
        Route::get('listar-categorias-fomag', 'categoriasFomag');
        Route::get('listar-categorias-medicina-integral', 'listarCategoriasMedicinaIntegral');
        Route::get('listar-comentarios-mesa-ayuda-medicina-integral/{id}', 'listarComentariosMesaAyudaMedicinaIntegral');
        Route::get('listar-comentarios-mesa-ayuda-fomag/{id}', 'listarComentariosMesaAyudaFomag');
        Route::post('reasignar-mesa-ayuda-fomag/{id}', 'reasignarMesaAyudaFomag');
        Route::post('comentario-mesa-ayuda-fomag/{id}', 'comentarioMesaAyudaFomag');
        Route::post('solucionar-mesa-ayuda-fomag/{id}', 'solucionarMesaAyudaFomag');
        Route::post('reasignar-mesa-ayuda-medicina-integral/{id}', 'reasignarMesaAyudaMedicinaIntegral');
        Route::post('comentario-mesa-ayuda-medicina-integral/{id}', 'comentarioMesaAyudaMedicinaIntegralInteroperabilidad');
        Route::post('solucionar-mesa-ayuda-medicina-integral/{id}', 'solucionarMesaAyudaMedicinaIntegral');
        Route::post('consultar-adjuntos-mesa-ayuda-fomag/{id}', 'consultarAdjuntosFomag');
        Route::post('consultar-adjuntos-mesa-ayuda-medicina-integral/{id}', 'consultarAdjuntosMedicinaIntegral');
    });
});
