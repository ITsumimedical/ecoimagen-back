<?php

use App\Http\Modules\Pabellones\Controllers\PabellonesController;
use App\Http\Modules\Urgencias\Oxigeno\Controllers\OxigenoController;
use Illuminate\Support\Facades\Route;

Route::prefix('oxigeno')->group( function () {
    Route::controller(OxigenoController::class)->group(function (){
        Route::post('listarOxigeno','listarOxigeno');//->middleware('permission:orientacionSexual.listar');
        Route::post('crear','crear');//->middleware('permission:orientacionSexual.crear');
        Route::put('/{id}','actualizar');
    });
});
