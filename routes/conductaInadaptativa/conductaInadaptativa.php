<?php

use App\Http\Modules\ConductasInadaptativas\Controller\ConductaInadaptativaController;
use Illuminate\Support\Facades\Route;


Route::prefix('conductaInadaptativa')->group(function (){
    Route::controller(ConductaInadaptativaController::class)->group(function (){
        Route::post('crear', 'crear');
    });
});
