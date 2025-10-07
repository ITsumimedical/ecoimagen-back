<?php

use App\Http\Modules\Georeferenciacion\Controllers\GeoreferenciacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('georreferencia')->group(function () {
    Route::controller(GeoreferenciacionController::class)->group(function (){
        Route::post('listar','listar');//->middleware('permission:contrato.georreferencia.listar');
        Route::post('','crear');//->middleware('permission:contrato.georreferencia.crear');
        Route::put('actualizar/{georreferencia}', 'actualizar');
    });
});
