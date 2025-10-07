<?php

use App\Http\Modules\EntidadesCodesumiParametrizacion\Controller\CodesumiEntidadController;
use Illuminate\Support\Facades\Route;


Route::prefix('codesumi-entidad')->group(function () {
    Route::controller(CodesumiEntidadController::class)->group(function () {
        Route::post('crear-parametrizacion-codesumi', 'crearParametrizacionCodesumi');
        Route::get('listar-parametrizacion-codesumi/{codesumi_id}', 'listarParametrizacionesCodesumi');
        Route::put('actualizar-parametrizacion-codesumi/{id}', 'actualizarParametrizacionEntidad');
        Route::post('agregar-programas-codesumi-entidad/{id}', 'agregarCodesumisPrograma');
    });
});
