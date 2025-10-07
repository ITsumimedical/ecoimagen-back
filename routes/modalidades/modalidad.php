<?php

use App\Http\Modules\Citas\Controllers\ModalidadController;
use Illuminate\Support\Facades\Route;

Route::prefix('modalidad', 'throttle:60,1')->group(function () {
    Route::controller(ModalidadController::class)->group(function() {
        Route::get('' , 'listar');
    });
});
