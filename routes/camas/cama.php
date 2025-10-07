<?php

use App\Http\Modules\Camas\Controllers\CamaController;
use Illuminate\Support\Facades\Route;

Route::prefix('cama')->group( function () {
    Route::controller(CamaController::class)->group(function (){
        Route::get('listar','listar');//->middleware('permission:orientacionSexual.listar');
        Route::post('crear','crear');//->middleware('permission:orientacionSexual.crear');
        Route::put('/{id}','actualizar');//->middleware('permission:orientacionSexual.actualizar');
        Route::put('cambiarEstado/{id}','cambiarEstado');
        Route::get('contadorObservacion','contadorObservacion');
        Route::post('listarCamaCenso','listarCamaCenso');
    });
});
