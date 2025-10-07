<?php

use App\Http\Modules\Historia\AntecedentesTransfusionales\Controllers\AntecedenteTransfusionalesController;
use Illuminate\Support\Facades\Route;

Route::prefix('antecedentes-transfusionales', 'throttle:60,1')->group(function () {
    Route::controller(AntecedenteTransfusionalesController::class)->group(function () {
        Route::post('guardar', 'guardar'); //->middleware('permission:tutela.gestion.buscar');
        Route::post('listar', 'listar'); //->middleware('permission:tutela.gestion.buscar');
        Route::delete('eliminar/{id}', 'eliminar'); //->middleware('permission:tutela.gestion.buscar');
    });
});
