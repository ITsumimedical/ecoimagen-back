<?php

use App\Http\Modules\TipoLicenciasEmpleados\Controllers\TipoLicenciaController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipos-licencias')->group( function () {
    Route::controller(TipoLicenciaController::class)->group(function (){
        Route::get('listar','listar')    ;//->middleware('permission:tipoLicencia.listar');
        Route::post('crear','crear')     ;//->middleware('permission:tipoLicencia.crear');
        Route::put('/{id}','actualizar') ;//->middleware('permission:tipoLicencia.actualizar');
    });
});
