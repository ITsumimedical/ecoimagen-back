<?php

use App\Http\Modules\Proveedores\Controllers\ProveedorController;
use Illuminate\Support\Facades\Route;

Route::prefix('proveedor', 'throttle:60,1')->group(function () {
    Route::controller(ProveedorController::class)->group(function () {
        Route::get('', 'listar');
    });
});
