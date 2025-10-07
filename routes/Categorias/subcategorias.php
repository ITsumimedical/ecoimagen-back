<?php


use App\Http\Modules\Subcategorias\Controllers\SubcategoriasController;
use Illuminate\Support\Facades\Route;

Route::prefix('subcategorias')->group(function () {
    Route::controller(SubcategoriasController::class)->group(function () {
        Route::get('listar', 'listar');
        Route::get('listarTodos', 'listarTodos');
        Route::post('crear', 'crear');
        Route::put('/{id}', 'actualizar');
        Route::post('cambiarEstado/{id}', 'cambiarEstado');
        Route::get('listarPorId/{subcategoriaId}', 'listarPorId');
        Route::post('eliminarDerechosAsignados/{subcategoriaId}', 'eliminarDerechosAsignados');
        Route::post('asignarDerechos/{subcategoriaId}', 'asignarDerechos');
        Route::post('listarDerechosSubcategorias', 'listarDerechosSubcategorias');
    });
});
