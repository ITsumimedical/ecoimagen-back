<?php

use App\Http\Modules\Epicrisis\Controllers\EpicrisisController;
use Illuminate\Support\Facades\Route;

Route::prefix('epicrisis', 'throttle:60,1')->group(function () {
    Route::controller(EpicrisisController::class)->group(function (){
        Route::post('crear', 'crear');
        Route::post('listar','listar');
        Route::get('listarRemision','listarRemision');
        Route::post('registroReferencia','registroReferencia');
        Route::post('listarHistoricoReferencia','listarHistoricoReferencia');
    });
});
