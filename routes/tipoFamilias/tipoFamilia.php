<?php

use App\Http\Modules\TipoFamilia\Controllers\TipoFamiliaController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-familia')->group(function () {
    Route::controller(TipoFamiliaController::class)->group(function (){
        Route::get('','listar')                                        ;//->middleware('permission:tipoFamilia.listar');
        Route::post('','guardar')                                      ;//->middleware('permission:tipoFamilia.crear');
        Route::put('/{tipoFamilia}','actualizar')                      ;//->middleware('permission:tipoFamilia.actualizar');
        Route::get('/consultar/{tipo_familia}','consultar')            ;//->middleware('permission:tipoFamilia.listar');
        Route::put('/cambiar-estado/{tipo_familia}', 'cambiarEstado')  ;//->middleware('permission:tipoFamilia.actualizar');
    });
});
