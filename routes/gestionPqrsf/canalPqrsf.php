<?php

use App\Http\Modules\GestionPqrsf\Canales\Controllers\CanalpqrsfController;
use Illuminate\Support\Facades\Route;

Route::prefix('canales-pqrsf')->group( function () {
    Route::controller(CanalpqrsfController::class)->group(function (){
        Route::post('listar','listar');
        Route::post('listarTodos','listarTodos');
        Route::post('crear','crear');
        Route::put('/{id}','actualizar');
        Route::post('cambiarEstado/{id}','cambiarEstado');
    });
});
