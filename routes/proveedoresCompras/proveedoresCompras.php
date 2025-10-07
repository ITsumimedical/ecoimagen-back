<?php

use App\Http\Modules\ProveedoresCompras\Controllers\ProveedoresComprasController;
use Illuminate\Support\Facades\Route;

Route::prefix('proveedores-compras')->group(function () {
    Route::controller(ProveedoresComprasController::class)->group(function (){
        Route::post('crear-proveedores', 'crearProveedor');
        Route::get('listar-proveedores', 'listarProveedor');
        Route::post('cambiar-estado/{id}', 'cambiarEstado');
       Route::get('contadores-proveedor', 'contadoresProveedor');
       Route::post('proveedores-lineas', 'proveedoresLineas');
       Route::post('modificar-proveedor/{id}', 'modificarProveedor');
       Route::get('obtener-adjuntos/{id}', 'obtenerAdjuntosPorProveedorId');
       Route::post('carga-masiva', 'cargaMasiva');
    });
});