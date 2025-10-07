<?php

use App\Http\Modules\Subregion\Controllers\SubregionController;
use Illuminate\Support\Facades\Route;

Route::prefix('subregion', 'throttle:60,1')->group(function () {
    Route::controller(SubregionController::class)->group(function() {
        Route::get('listarSubregion', 'listarSubregion');//->middleware(['permission:subregion.listar']);
        Route::post('', 'guardar');//->middleware(['permission:subregion.guardar']);
        Route::put('/{id}', 'actualizar');//->middleware(['permission:subregion.guardar']);
    });
});
