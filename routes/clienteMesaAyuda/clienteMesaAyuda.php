<?php

use App\Http\Modules\ClienteMesaAyuda\Controllers\ClientemesaayudaController;
use Illuminate\Support\Facades\Route;

Route::prefix('clientesMesaAyuda', 'throttle:60,1')->group(function () {
    Route::post('crear-clientes',[ClientemesaayudaController::class,'crearClienteMesaAyuda']);
    Route::get('listar', [ClientemesaayudaController::class, 'listar']);
    Route::post('editar/{id}', [ClientemesaayudaController::class, 'editar']);
});
