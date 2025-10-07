<?php

use App\Http\Modules\EtiquetasTH\Controllers\EtiquetaThController;
use Illuminate\Support\Facades\Route;

Route::prefix('etiqueta-th')->group( function () {
    Route::controller(EtiquetaThController::class)->group(function (){
        Route::get('listar','listar');//->middleware('permission:etiquetaTh.listar');
        Route::post('crear','crear');//->middleware('permission:etiquetaTh.crear');
        Route::put('/{id}','actualizar');//->middleware('permission:etiquetaTh.actualizar');
        Route::get('exportar', 'exportar');
    });
});
