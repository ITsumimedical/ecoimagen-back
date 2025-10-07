<?php

use App\Http\Modules\TratamientosCronicos\Controller\TratamientosCronicosController;
use Illuminate\Support\Facades\Route;

Route::prefix('tratamientos-cronicos', 'throttle:60,1')->group(function () {
    Route::controller(TratamientosCronicosController::class)->group(function() {
        Route::post('crear-tratamiento', 'crear');
        Route::get('listar-tratamientos-afiliado/{afiliado_id}', 'listarPorAfiliado');
        Route::delete('eliminar-tratamiento/{tratamiento_id}', 'eliminarTratamiento');
    });
});
