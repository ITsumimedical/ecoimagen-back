<?php

use App\Http\Modules\ParaclinicosOdontologia\Controllers\paraclinicosOdontologiaController;
use Illuminate\Support\Facades\Route;

Route::prefix('paraclinicoOdontologia', 'throttle:60,1')->group(function () {
    Route::controller(paraclinicosOdontologiaController::class)->group(function (){
        Route::post('crear', 'crear');
    });
});
