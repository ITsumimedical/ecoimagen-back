<?php

use App\Http\Modules\MesaAyuda\CategoriaMesaAyuda\controllers\CategoriaMesaAyudaController;
use Illuminate\Support\Facades\Route;

Route::prefix('CategoriaMesaAyuda', 'throttle:60,1')->group(function (){
    Route::controller(CategoriaMesaAyudaController::class)->group(function (){
        Route::get('listar', 'listar');     //  ->middleware('permission:CategoriaMesaAyuda.listar');
        Route::get('listarTodas', 'listarTodas');     //  ->middleware('permission:CategoriaMesaAyuda.listar');
        Route::get('listarCategoria_Area/{area}', 'listarCategoria_Area');
        Route::post('crear', 'crear')  ;    // ->middleware('permission:CategoriaMesaAyuda.crear');
        Route::put('/{id}', 'actualizar');  // ->middleware('permission:CategoriaMesaAyuda.actualizar');
        Route::post('cambiarEstado/{id}', 'cambiarEstado');  // ->middleware('permission:CategoriaMesaAyuda.actualizar');
    });//
});
