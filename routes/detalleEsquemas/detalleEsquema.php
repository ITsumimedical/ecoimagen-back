<?php

use App\Http\Modules\DetalleEsquemas\Controllers\DetalleEsquemasController;
use Illuminate\Support\Facades\Route;

Route::prefix('detalle-esquema', 'throttle:60,1')->group(function (){
    Route::controller(DetalleEsquemasController::class)->group(function (){
        Route::get('listar', 'listar');//->middleware(['permission:listar.estados']);
        Route::post('crear', 'crear');//->middleware(['permission:crear.estado']);
        Route::put('actualizar/{id}', 'actualizar');//->middleware(['permission:actualizar.estado']);
    });
});
