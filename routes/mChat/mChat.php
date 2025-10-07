<?php

use App\Http\Modules\testMchat\Controller\mChatController;
use Illuminate\Support\Facades\Route;

Route::prefix('testMchat', 'throttle:60,1')->group(function () {
    Route::controller(mChatController::class)->group(function() {
        Route::post('crear', 'crear');
        Route::get('obtenerDatos/{afiliadoId}', 'obtenerDatos');
    });
});
