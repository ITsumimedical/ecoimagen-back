<?php

use App\Http\Modules\PqrsfTipoCanales\Controllers\PqrsfTipoCanalController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-canal-pqrsf', 'throttle:60,1')->group(function () {
    Route::controller(PqrsfTipoCanalController::class)->group(function() {
        Route::get('listar', 'listar')     ;//->middleware(['permission:tipoCanalPqrsf.listar']);
        Route::post('crear', 'crear')      ;//->middleware(['permission:tipoCanalPqrsf.crear']);
        Route::put('/{id}', 'actualizar')  ;//->middleware(['permission:tipoCanalPqrsf.actualizar']);
    });
});
