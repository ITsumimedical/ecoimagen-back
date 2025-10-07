<?php

use App\Http\Modules\EntidadExamenLaborales\Controllers\EntidadExamenLaboralController;
use Illuminate\Support\Facades\Route;

Route::prefix('entidad-examen-laboral')->group( function () {
    Route::controller(EntidadExamenLaboralController::class)->group(function (){
        Route::get('listar','listar');//->middleware('permission:entidadExamenLaboral.listar');
        Route::post('crear','crear');//->middleware('permission:entidadExamenLaboral.crear');
        Route::put('/{id}','actualizar');//->middleware('permission:entidadExamenLaboral.actualizar');
    });
});
