<?php

use App\Http\Modules\AreasProveedores\Controllers\AreasProveedoresController;
use Illuminate\Support\Facades\Route;

Route::prefix('areas-proveedores')->group(function () {
    Route::controller(AreasProveedoresController::class)->group(function (){
        Route::post('crear-areas', 'crearAreasProveedores');
        Route::get('listar-areas', 'listarAreasProveedores');
        Route::post('modificar-area/{id}', 'modificarArea');
        Route::post('cambiar-estado/{id}', 'cambiarEstado');
        Route::post('asignar-usuarios/{id}', 'asignarUsuariosporAreas');
        Route::get('listar-operadores/{id}', 'listarOperadoresPorArea');
    });
});