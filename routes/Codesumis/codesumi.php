<?php

use App\Http\Modules\Codesumis\codesumis\Controllers\CodesumiController;
use Illuminate\Support\Facades\Route;

Route::prefix('codesumis')->group(function () {
    Route::controller(CodesumiController::class)->group(function () {
        Route::post('listarCodigosSumi', 'listarCodigosSumi');
        Route::post('crear', 'crear');
        Route::put('actualizar/{id}', 'actualizar');
        Route::post('buscar', 'buscar');
        Route::post('codesumiEsquema', 'codesumiEsquema');
        Route::post('cambiarEstadoProducto', 'cambiarEstadoProducto');
        Route::post('sincronizarPrincipios', 'sincronizarPrincipiosActivos');
        Route::post('listarPrincipiosAsociados/{codesumi_id}', 'obtenerPrincipios');
        Route::post('agregar-vias-administracion-codesumi', 'agregarViaAdministracionCodesumi');
        Route::get('listar-vias-administracion-codesumi/{codesumi_id}', 'listarViasAdministracionPorCodesumi');
        Route::get('validar-contratacion-codesumi/{afiliado_id}/{codesumi_id}', 'validarContratacionCodesumi');
    });
});
