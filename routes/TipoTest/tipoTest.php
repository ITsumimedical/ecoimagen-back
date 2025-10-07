<?php

use App\Http\Modules\TipoTest\Controllers\tipoTestController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipoTest')->group(function () {
    Route::controller(tipoTestController::class)->group(function (){
        Route::get('listar', 'listar');
        Route::post('crearTipoTest','crearTipoTest');
        Route::put('actualizar/{id}', 'actualizar');
    });
});
