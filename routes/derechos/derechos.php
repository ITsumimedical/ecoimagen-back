<?php

use App\Http\Modules\Pqrsf\Derechos\Controllers\DerechosController;
use Illuminate\Support\Facades\Route;

Route::prefix('derechos', 'throttle:60,1')->group(function () {
    Route::controller(DerechosController::class)->group(function () {
        Route::get('listarDerechos', 'listarDerechos'); //->middleware('permission:cargos.listar');
        Route::post('crearDerecho', 'crearDerecho'); //->middleware('permission:cargos.crear');
        Route::post('cambiarEstadoDerecho/{derechoId}', 'cambiarEstadoDerecho'); //->middleware('permission:cargos.crear');
        Route::get('listarDerechoPorId/{derechoId}', 'listarDerechoPorId'); //->middleware('permission:cargos.crear');
        Route::post('editarDerecho/{derechoId}', 'editarDerecho'); //->middleware('permission:cargos.crear','');
        Route::get('listarActivos', 'listarActivos');
    });
});
