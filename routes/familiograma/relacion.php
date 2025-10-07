<?php

use App\Http\Modules\Familiograma\Controllers\RelacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('relaciones')->group(function () {
    Route::controller(RelacionController::class)->group(function () {
        Route::post('crearRelacion', 'crearRelacion');
        Route::post('listarRelaciones', 'listarRelaciones');
    });
});
