<?php

use App\Http\Modules\OrientacionesSexuales\Controllers\OrientacionSexualController;
use Illuminate\Support\Facades\Route;

Route::prefix('orientaciones-sexuales')->group( function () {
    Route::controller(OrientacionSexualController::class)->group(function (){
        Route::get('listar','listar');//->middleware('permission:orientacionSexual.listar');
        Route::post('crear','crear');//->middleware('permission:orientacionSexual.crear');
        Route::put('/{id}','actualizar');//->middleware('permission:orientacionSexual.actualizar');
        Route::get('exportar', 'exportar');
    });
});
