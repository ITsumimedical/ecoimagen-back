<?php

use App\Http\Modules\Subgrupos\Controllers\SubgrupoController;
use Illuminate\Support\Facades\Route;

Route::prefix('subgrupos', 'throttle:60,1')->group(function () {
    Route::controller(SubgrupoController::class)->group(function () {
        Route::get('listar', 'listar');
        Route::post('crear','crear');
        Route::put('actualizar/{id}','actualizar');

    });
});
