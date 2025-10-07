<?php

use App\Http\Modules\Ecomapa\Controllers\RelacionEcomapaController;
use Illuminate\Support\Facades\Route;

Route::prefix('relaciones-ecomapa')->group(function () {
    Route::controller(RelacionEcomapaController::class)->group(function () {
        Route::post('crearRelacion', 'crearRelacion');
        Route::post('listarRelaciones', 'listarRelaciones');
    });
});
