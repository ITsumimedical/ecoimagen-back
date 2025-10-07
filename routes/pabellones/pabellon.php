<?php

use App\Http\Modules\Pabellones\Controllers\PabellonesController;
use Illuminate\Support\Facades\Route;

Route::prefix('pabellon')->group( function () {
    Route::controller(PabellonesController::class)->group(function (){
        Route::post('listar','listar');//->middleware('permission:orientacionSexual.listar');
        Route::post('crear','crear');//->middleware('permission:orientacionSexual.crear');
        Route::put('/{id}','actualizar');//->middleware('permission:orientacionSexual.actualizar');
        Route::put('cambiarEstado/{id}','cambiarEstado');
        Route::get('listarConCama','listarConCama');
    });
});
