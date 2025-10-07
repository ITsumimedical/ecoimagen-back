<?php

use App\Http\Modules\Paises\Controllers\PaisController;
use Illuminate\Support\Facades\Route;

Route::prefix('pais')->group(function () {
    Route::controller(PaisController::class)->group(function () {
        Route::post('listar', 'listar');//->middleware('permission:pais.listar');
    });
});
