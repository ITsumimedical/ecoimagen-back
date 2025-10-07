<?php

use App\Http\Modules\SalarioMinimo\Controllers\SalarioMinimoController;
use Illuminate\Support\Facades\Route;

Route::prefix('salario-minimo', 'throttle:60,1')->group(function () {
    Route::controller(SalarioMinimoController::class)->group(function() {
        Route::get('', 'listar');//->middleware('permission:contrato.salarioMinimo.listar');
        Route::post('','guardar');//->middleware('permission:contrato.salarioMinimo.guardar');
        Route::put('/{salario_minimo_id}','actualizar');//->middleware('permission:contrato.salarioMinimo.actualizar');
        Route::put('parametros/{salario_minimo_id}','actualizarParametros');//->middleware('permission:contrato.salarioMinimo.actualizar');
        Route::get('listarParametros/{salario_minimo_id}','listarParametros');//->middleware('permission:contrato.salarioMinimo.actualizar');
    });
});
