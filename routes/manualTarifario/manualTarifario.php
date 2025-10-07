<?php

use App\Http\Modules\ManualTarifario\Controllers\ManualTarifarioController;
use Illuminate\Support\Facades\Route;

Route::prefix('manual-tarifario')->group(function () {
    Route::controller(ManualTarifarioController::class)->group(function (){
        Route::get('','listar');//->middleware('permission:contratos.modalidadContrato.listar');
        Route::post('','crear');//->middleware('permission:contratos.modalidadContrato.crear');
        Route::put('/{manual_tarifario}','actualizar');//->middleware('permission:contratos.modalidadContrato.actualizar');
        Route::put('/cambiar-estado/{manual_tarifario}','cambiarEstado');//->middleware('permission:contratos.modalidadContrato.actualizar');
        Route::get('/{manual_tarifario}','consultar');//->middleware('permission:contratos.modalidadContrato.listar');
    });
});
