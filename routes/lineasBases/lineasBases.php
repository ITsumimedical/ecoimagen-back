<?php

use App\Http\Modules\Codesumis\lineasBases\Controllers\lineasBasesController;
use Illuminate\Support\Facades\Route;

Route::prefix('lineas-bases')->group(function () {
    Route::controller(lineasBasesController::class)->group(function (){
        Route::get('listar','listar');
        Route::post('crear','crear');
        Route::put('actualizar/{id}','actualizar');

    });
});
