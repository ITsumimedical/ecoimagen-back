<?php

use App\Http\Modules\TiposContratosTH\Controllers\TipoContratoThController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-contratos-ths', 'throttle:60,1')->group(function () {
    Route::controller(TipoContratoThController::class)->group(function () {
        Route::get('listar', 'listar');//->middleware(['permission:tipoContratoTh.listar']);
    });
});
