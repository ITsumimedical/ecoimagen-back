<?php

use App\Http\Modules\TiposCuentasBancarias\Controllers\TipoCuentabancariaController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipos-cuentas-bancarias')->group( function () {
    Route::controller(TipoCuentabancariaController::class)->group(function (){
        Route::get('listar','listar');//->middleware('permission:tipoCuentaBancaria.listar');
        Route::post('crear','crear');//->middleware('permission:tipoCuentaBancaria.crear');
        Route::put('/{id}','actualizar');//->middleware('permission:tipoCuentaBancaria.actualizar');
    });
});
