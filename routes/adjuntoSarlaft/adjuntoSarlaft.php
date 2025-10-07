<?php

use App\Http\Modules\AdjuntoSarlaft\Controllers\AdjuntoSarlaftController;
use Illuminate\Support\Facades\Route;

Route::prefix('adjunto-sarlaft', 'throttle:60,1')->group(function () {
    Route::controller(AdjuntoSarlaftController::class)->group(function() {
        Route::post('crear/{id_sarlaft}','crear');//->middleware(['permission:tutelas.adjunto.guardar']);

    });
});
