<?php

use App\Http\Modules\RepresentanteLegal\Controllers\RepresentanteLegalController;
use Illuminate\Support\Facades\Route;

Route::prefix('representante-legal', 'throttle:60,1')->group(function () {
    Route::controller(RepresentanteLegalController::class)->group(function () {
        Route::get('listar', 'listar')      ;
        Route::post('crear', 'crear')       ;

    });
});
