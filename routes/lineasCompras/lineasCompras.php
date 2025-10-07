<?php

use App\Http\Modules\LineasCompras\Controllers\LineasComprasController;
use Illuminate\Support\Facades\Route;

Route::prefix('lineas-compras')->group(function () {
    Route::controller(LineasComprasController::class)->group(function (){
        Route::post('crear-lineas', 'crearLinea');
        Route::get('listar-lineas', 'listarLinea');
        Route::post('modificar-linea/{id}', 'modificarLinea');
        Route::post('cambiar-estado/{id}', 'cambiarEstado');
    });
});