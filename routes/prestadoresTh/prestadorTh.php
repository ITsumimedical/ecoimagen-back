<?php

use App\Http\Modules\PrestadoresTH\Controllers\PrestadorThController;
use Illuminate\Support\Facades\Route;

Route::prefix('prestador-th')->group( function () {
    Route::controller(PrestadorThController::class)->group(function (){
        Route::get('listar','listar');//->middleware('permission:prestadorTh.listar');
        Route::get('{id}','listarPrestador');//->middleware('permission:prestadorTh.listar');
        Route::post('crear','crear');//->middleware('permission:prestadorTh.crear');
        Route::put('/{id}','actualizar');//->middleware('permission:prestadorTh.actualizar');
    });
});
