<?php

use App\Http\Modules\ConductasRelacionamiento\Controller\ConductaRelacionamientoController;
use Illuminate\Support\Facades\Route;


Route::prefix('conducta')->group(function (){
    Route::controller(ConductaRelacionamientoController::class)->group(function (){
        Route::post('crear', 'crear');
    });
});
