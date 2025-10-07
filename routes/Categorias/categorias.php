<?php

use App\Http\Modules\categorias\Controllers\CategoriasController;
use Illuminate\Support\Facades\Route;

Route::prefix('categorias')->group( function () {
    Route::controller(CategoriasController::class)->group(function (){
        Route::get('listar','listar');
        Route::post('crear','crear');
    });
});
