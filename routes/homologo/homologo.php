<?php

use App\Http\Modules\Homologo\Controller\HomologoController;
use Illuminate\Support\Facades\Route;

Route::prefix('homologo', 'throttle:60,1')->group(function () {
    Route::controller(HomologoController::class)->group(function () {
        Route::post('', 'listar');//->middleware('permission:homologo.listar');
        Route::post('subirArchivo', 'subirArchivo');//->middleware('permission:homologo.actualizacionMasiva');
    });
});
