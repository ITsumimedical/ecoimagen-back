<?php

use App\Http\Modules\Caracterizacion\Controllers\CaracterizacionController;
use App\Http\Modules\Caracterizacion\Controllers\EncuestaController;
use Illuminate\Support\Facades\Route;

Route::prefix('caracterizacion')->group(function () {
    Route::controller(CaracterizacionController::class)->group(function () {
        Route::get('listar/{afiliado_id}', 'listar');
        Route::post('crear', 'crear');
        Route::put('{id}', 'actualizar');
        Route::post('auditoria/{id}', 'auditoriaCaracterizacion');

        Route::post('guardar-caracterizacion-ecis', 'guardarCaracterizacionEcis');
        Route::get('buscar-caracterizacion-ecis-afiliado', 'buscarCaracterizacionEcisAfiliado');
        Route::post('agregar-integrante-caracterizacion-ecis', 'agregarIntegranteCaracterizacionEcis');
        Route::get('listar-integrantes-familia/{afiliado_id}', 'listarIntegrantesFamilia');
        Route::delete('eliminar-integrante-familia-afiliado/{integrante_id}/{afiliado_id}', 'eliminarIntegranteFamiliaAfiliado');
        Route::post('asociar-integrante-existente', 'asociarIntegranteExistente');
        Route::get('validar-caracterizacion-ecis/{afiliado_id}', 'validarCaracterizacionEcis');
    });
    Route::controller(EncuestaController::class)->group(function () {
        Route::post('crear-encuesta', 'crearEncuesta');
        Route::post('crear-encuesta-id/{afiliado_id}', 'crearEncuestaId');
        Route::get('obtener-caracterizacion-por-afiliado/{afiliado_id}', 'obtenerCaracterizacionPorAfiliado');
        Route::put('actualizar-encuesta/{id}', 'actualizarEncuesta');
    });

});

