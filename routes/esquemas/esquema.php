<?php

use App\Http\Modules\Esquemas\Controllers\EsquemaController;
use Illuminate\Support\Facades\Route;

Route::prefix('esquema', 'throttle:60,1')->group(function (){
    Route::controller(EsquemaController::class)->group(function (){
        Route::get('listar', 'listar');//->middleware(['permission:listar.estados']);
        Route::post('crear', 'crear');//->middleware(['permission:crear.estado']);
        Route::put('actualizar/{id}', 'actualizar');//->middleware(['permission:actualizar.estado']);
    });
});
