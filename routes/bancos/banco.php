<?php

use App\Http\Modules\Bancos\Controllers\BancoController;
use Illuminate\Support\Facades\Route;

Route::prefix('bancos')->group( function () {
    Route::controller(BancoController::class)->group(function (){
        Route::get('listar','listar');//->middleware('permission:banco.listar');
        Route::post('crear','crear');//->middleware('permission:banco.crear');
        Route::put('/{id}','actualizar');//->middleware('permission:banco.actualizar');
    });
});
