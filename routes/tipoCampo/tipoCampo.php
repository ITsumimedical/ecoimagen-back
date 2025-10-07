<?php

use App\Http\Modules\TipoCampo\Controllers\TipoCampoController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-campo','throttle:60,1')->group(function (){
    Route::controller(TipoCampoController::class)->group(function (){
        Route::get('listar','listar');//->middleware('permission:tipoCampo.listar');
        Route::post('crear','crear');//->middleware('permission:tipoCampo.crear');
        Route::put('/{id}','actualizar');//->middleware('permission:tipoCampo.actualizar');
    });
});
