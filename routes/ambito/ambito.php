<?php

use App\Http\Modules\Ambitos\Controllers\AmbitoController;
use Illuminate\Support\Facades\Route;

Route::prefix('ambito')->group(function () {
    Route::controller(AmbitoController::class)->group(function () {
        Route::get('','listar');//->middleware('permission:ambitos.listar');
    });
});
