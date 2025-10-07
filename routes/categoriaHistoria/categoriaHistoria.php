<?php

use App\Http\Modules\CategoriaHistorias\Controllers\CategoriaHistoriaController;
use Illuminate\Support\Facades\Route;

Route::prefix('categoria-historia','throttle:60,1')->group(function () {
    Route::controller(CategoriaHistoriaController::class)->group(function () {
        Route::get('listar','listar');
        Route::post('crear','crear');
        Route::put('/{id}','actualizar');
        Route::get('tipocategoria','tipoCategoriaHistorias');
    });
});
