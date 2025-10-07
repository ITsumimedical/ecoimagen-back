<?php

use App\Http\Modules\TipoPrestadoresTH\Controllers\TipoPrestadorThController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-prestador-th', 'throttle:60,1')->group(function () {
    Route::controller(TipoPrestadorThController::class)->group(function() {
        Route::get('listar', 'listar');//->middleware(['permission:tipoPrestadorTh.listar']);
    });
});
