<?php

use App\Http\Modules\Oncologia\Organos\Controllers\OrganoController;
use Illuminate\Support\Facades\Route;

Route::prefix('organos', 'throttle:60,1')->group(function (){
    Route::controller(OrganoController::class)->group(function (){
        Route::get('listar', 'listar');//->middleware('permission:organos.listar');
        Route::post('crear', 'crear');//->middleware('permission:organo.crear');
        Route::put('/{id}', 'actualizar');//->middleware('permission:organo.actualizar');
    });
});
