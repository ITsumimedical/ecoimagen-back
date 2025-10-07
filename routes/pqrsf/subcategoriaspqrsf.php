<?php

use App\Http\Modules\Pqrsf\SubcategoriasPqrsf\Controller\subcategoriasPqrsfController;
use Illuminate\Support\Facades\Route;

Route::prefix('subcategorias-pqrsf', 'throttle:60,1')->group(function () {
    Route::controller(subcategoriasPqrsfController::class)->group(function () {
        Route::post('crear', 'crear');
        Route::post('listar', 'listar');
        Route::post('eliminar', 'eliminar');
        Route::post('actualizar', 'actualizar');
        Route::post('actualizarSubcategorias/{pqrsfId}', 'actualizarSubcategorias');
    });
});
