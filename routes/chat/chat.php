<?php

use App\Http\Modules\Chat\Controllers\CanalController;
use Illuminate\Support\Facades\Route;

Route::prefix('chat','throttle:60,1')->group(function () {
    Route::controller(CanalController::class)->group(function () {
        Route::get('listar/{user_id}','listar');
        Route::post('crear','crear');
        Route::put('/{id}','actualizar');
    });
});
