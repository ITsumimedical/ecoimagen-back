<?php

use App\Http\Modules\OrganosFonoarticulatorios\Controllers\OrganosFonoarticulatoriosController;
use Illuminate\Support\Facades\Route;

Route::prefix('organosFonoarticulatorios')->group( function () {
    Route::controller(OrganosFonoarticulatoriosController::class)->group( function () {
        Route::post('crear', 'crear');
    });
});
