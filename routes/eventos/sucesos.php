<?php

use App\Http\Modules\Eventos\Sucesos\Controllers\SucesoController;
use Illuminate\Support\Facades\Route;

Route::prefix('sucesos')->group( function () {
    Route::controller(SucesoController::class)->group(function (){
        Route::get('listar','listar');//->middleware('permission:suceso.listar');
        Route::post('crear','crear');//->middleware('permission:suceso.crear');
        Route::put('/{id}','actualizar');//->middleware('permission:suceso.actualizar');
    });
});
