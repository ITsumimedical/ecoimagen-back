<?php

use App\Http\Modules\sindromesGeriatricos\Controllers\SindromesGeriatricosController;
use Illuminate\Support\Facades\Route;

Route::prefix('sindromesGeriatricos', 'throttle:60,1')->group(function () {
    Route::controller(SindromesGeriatricosController::class)->group(function () {
        Route::post('crearSindrome','crearSindrome');

    });
});
