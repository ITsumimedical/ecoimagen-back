<?php

use App\Http\Modules\Familias\Controllers\FamiliaController;
use Illuminate\Support\Facades\Route;

Route::prefix('familia')->group(function () {
    Route::controller(FamiliaController::class)->group(function (){
        Route::post('listar','listar');//->middleware('permission:familia.listar');
        Route::post('','crear');//->middleware('permission:familia.crear');
        Route::get('/{tarifa_id}','listarFamiliaTarifas');//->middleware('permission:familia.listar');
        Route::post('/sincronizarTarifa/{tarifa_id}','sincronizarTarifas');//->middleware('permission:familia.crear');
        Route::put('/{familia}','actualizar');//->middleware('permission:familia.actualizar');
        Route::get('/consultar/{id}','consultar');//->middleware('permission:familia.listar');
        Route::put('/cambiar-estado/{familia}','cambiarEstado');//->middleware('permission:familia.actualizar');
        Route::put('/sincronizar-cups/{familia}','sincronizarCups');//->middleware('permission:familia.actualizar');
        Route::post('/cups','familiaCups');//->middleware('permission:familia.listar');
    });
});
