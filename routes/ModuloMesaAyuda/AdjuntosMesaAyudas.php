<?php

use App\Http\Modules\MesaAyuda\AdjuntosMesaAyudas\Controllers\AdjuntosMesaAyudasController;
use Illuminate\Support\Facades\Route;

Route::prefix('AdjuntosMesaAyudas', 'throttle:60,1')->group(function (){
    Route::controller(AdjuntosMesaAyudasController::class)->group(function (){
        Route::get('listar', 'listar');  //   ->middleware('permission:AdjuntosMesaAyudas.listar');
        Route::post('crear', 'crear')  ;    // ->middleware('permission:AdjuntosMesaAyudas.crear');
        Route::put('/{id}', 'actualizar');   //->middleware('permission:AdjuntosMesaAyudas.actualizar');
    });
});
