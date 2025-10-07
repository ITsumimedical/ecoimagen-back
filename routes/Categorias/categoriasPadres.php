<?php

use App\Http\Modules\categoriasPadres\Controllers\CategoriaPadreController;
use Illuminate\Support\Facades\Route;

Route::prefix('categorias-padres')->group( function () {
    Route::controller(CategoriaPadreController::class)->group(function (){
        Route::get('listar','listar');
        Route::post('crear','crear');
    });
});
